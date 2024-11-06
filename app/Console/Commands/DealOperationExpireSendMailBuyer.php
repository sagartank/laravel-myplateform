<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\DealOperationExpireToBuyer;
use App\Models\Offer;

class DealOperationExpireSendMailBuyer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deal:operation-expire-mail-buyer';
    // protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send expiration email to the buyer for expired deals operation.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        $expiration_date_before = Carbon::now()->addDay(2)->format('Y-m-d');

        $resultOffers = Offer::with([
            'buyer:id,name,email',  
            'operations' => function($qry) {
                $qry->OperationSelect();
                $qry->with([
                    'seller:id,name,email',
                ]);
            },
            ])
            ->whereHas('operations', function ($query) use ($expiration_date_before) {
                $query->whereDate('expiration_date', '<', $expiration_date_before);
            })
            ->where('offer_status', 'Approved')
            ->where('is_cashed_buyer', 'No')
            ->where('is_mipo_commission_payment', 'Yes')
            ->get();

            if($resultOffers && $resultOffers->count() > 0) {
                foreach($resultOffers as $resultOffer) {
                    if($resultOffer->operations) {
                        foreach($resultOffer->operations as $operation) {
                            if($operation->pivot->is_offered == '1') {
                                $operation_number = $operation->operation_number;
                                $operation_type = $operation->operation_type;
                                $operation_slug = $operation->slug;
                                $email = $resultOffer->buyer->email;
                                $name = $resultOffer->buyer->name;
                                $deal_slug = $resultOffer->slug;
                                $deal_id = $resultOffer->id;
                                
                                if($email!='') {

                                    Mail::to('sagartank.w3nuts@gmail.com')->send(new DealOperationExpireToBuyer($name));
                                    Mail::to($email)->send(new DealOperationExpireToBuyer($name));
                                    
                                    $this->info('Expiration emails sent successfully!');
                                    
                                    // return Command::SUCCESS;
                                }
                            }   
                        }
                    }
                }
            }
    }
}
