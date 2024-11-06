<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Uuid;
use App\Models\OperationsLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Offer extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes,LogsActivity;

    protected $guarded = [];

    protected $appends = ['offer_expire_days', 'offer_expire_date_iso', 'offer_expire_hour', 'offer_expire_at', 'offer_created_date_iso'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    public function getOfferExpireDaysAttribute()
    {
        $datework = Carbon::createFromDate($this->expires_at);
        $now = Carbon::now();
        return $datework->diffInDays($now);
    }

    public function getOfferExpireAtAttribute()
    {
      /*   $get_value = Carbon::createFromDate($this->expires_at)->diffForHumans();
        return str_replace('from now', '',  $get_value); */

        $get_value = Carbon::createFromDate($this->expires_at)->diffForHumans();
        $inputString =  str_replace('from now', '',  $get_value);

        $parts = explode(' ', $inputString);
        $stringPart = implode(' ', array_slice($parts, 1));
        
       return $parts[0] .' '. __($stringPart);
    }

    public function getOfferExpireHourAttribute()
    {
        $datework = Carbon::createFromDate($this->expires_at);
        $now = Carbon::now();
        return $datework->diffInHours($now);
    }

    public function getOfferExpireDateIsoAttribute()
    {
        // return Carbon::createFromDate($this->expires_at)->format('jS F Y');
        if(!empty($this->expires_at)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->expires_at)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->expires_at)->format('m')] .' de '. Carbon::createFromDate($this->expires_at)->format('Y');
            } else {
                return  Carbon::createFromDate($this->expires_at)->format('F') .' '. Carbon::createFromDate($this->expires_at)->format('j') .', '. Carbon::createFromDate($this->expires_at)->format('Y');
            }
        } else {
            return  '-';
        }
    }

    
    public function getOfferCreatedDateIsoAttribute()
    {
        if(!empty($this->updated_at)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->updated_at)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->updated_at)->format('m')] .' de '. Carbon::createFromDate($this->updated_at)->format('Y');
            } else {
                return  Carbon::createFromDate($this->updated_at)->format('F') .' '. Carbon::createFromDate($this->updated_at)->format('j') .', '. Carbon::createFromDate($this->updated_at)->format('Y');
            }
        } else {
            return  '-';
        }
        // return Carbon::createFromDate($this->updated_at)->format('jS F Y');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function operations()
    {
        // return $this->belongsToMany(Operation::class, 'offer_operations')->withPivot('id', 'operation_id')->using(OfferOperation::class); old working  after group 1_8_2023
        return $this->belongsToMany(Operation::class, 'offer_operations')->withPivot('id', 'operation_id', 'is_disputed', 'disputed_note', 'is_cashed_buyer', 'is_cashed_buyer_date', 'is_rated_buyer', 'is_offered')->using(OfferOperation::class); // new add filed 2_8_2023
    }

    public function counter_offers()
    {
        return $this->hasMany(CounterOffer::class, 'offer_id', 'id')->orderBy('id','DESC');
    }

    protected static function booted()
    {
        static::creating(function ($offer) {
            if(Auth::check()) {
                $offer->created_by = Auth()->user()?->id;
                $offer->updated_by = Auth()->user()?->id;
            }
        });
        static::updating(function ($offer) {
            if(Auth::check()) {
                $offer->updated_by = Auth()->user()?->id;
                if($offer->id && $offer->id > 0) {
                    
                    $result_offer_operations = app('offer')->offerByOfferOperation(['offer_id' => $offer->id]);
                    
                    if($offer->offer_status == 'Approved' && $result_offer_operations) {
                        foreach($result_offer_operations as $offer_operation) {
                            OperationsLogs::operationsAddLogs(1, '0', 'Seller', $offer->id);
                        }
                    }
                    
                    if($offer->offer_status == 'Rejected' && $result_offer_operations) {
                        foreach($result_offer_operations as $offer_operation) {
                            OperationsLogs::operationsAddLogsTitle($offer_operation->operation_id, 'Offer Rejected', $offer->id);
                        }
                    }
                    
                    if($offer->offer_status == 'Counter' && $result_offer_operations) {
                        foreach($result_offer_operations as $offer_operation) {
                            OperationsLogs::operationsAddLogsTitle($offer_operation->operation_id, 'Offer Counter', $offer->id);
                        }
                    }
                }
            }
        });
    }

    public function offers_logs()
    {
        return $this->hasMany(OperationsLogs::class, 'offer_id', 'id')->orderBy('id','DESC');
    }

    public function offers_history()
    {
        return $this->hasMany(OffersHistory::class, 'offer_id', 'id')->orderBy('id','DESC');
    }

    public function deals_documents()
    {
        return $this->hasMany(DealsDocuments::class, 'offer_id', 'id')->orderBy('id','DESC');
    }

    public function deals_disputes()
    {
        return $this->hasMany(DealsDisputes::class, 'offer_id', 'id')->orderBy('id','DESC');
    }

    public function deals_contract()
    {
        return $this->hasOne(DealsContract::class, 'offer_id', 'id')->orderBy('id','DESC');
    }

    public function deals_seog()
    {
        return $this->hasOne(DealsSeog::class, 'offer_id', 'id')->orderBy('id','DESC');
    }
    
    public function deals_admin_file()
    {
        return $this->hasMany(DealsSeog::class, 'offer_id', 'id')->orderBy('id','DESC');
    }
}
