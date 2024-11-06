<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Deviam\Bancard\Bancard;
use Illuminate\Support\Facades\Session;
use App\Models\Plan;
use App\Models\UserPlanSubscription;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Offer;
use App\Models\OperationsLogs;

class PaymentController extends Controller
{
    public function paymentReturn(Request $request,$shop_process_id){
        info('Return:'.$shop_process_id);
        $response = Bancard::confirmation($shop_process_id);
        if ($response->failed()) {
            // Do something here.
            info($response);
        }
        $data = $response->json();
        $confirmation = $data['confirmation'];

        $dealSlug = Session::get('selectedDealsSlug');

        $dealMipoCommissionDealsSlug = Session::get('selectedMipoCommissionDealsSlug');
        
        $planSlug = Session::get('selectedPlanSlug');
        info('$planSlug:'.$planSlug);

        if($planSlug){
            /**
             * Save payment details along with user payment history for selected plan
             */
        //if($planSlug && $confirmation['response'] == "S"){
            $plan = Plan::with('userLevel')->where('slug',$planSlug)->first();
            //Get role associate with this plan
            $role = Role::where('display_name',$plan->userLevel->name)->first();
            $user = auth()->user();
            $currentDateTime = Carbon::now();

            $latest = UserPlanSubscription::latest()->first();
            if (! $latest) {
                $subscriptionNo = config('constants.SUBSCRIPTION_DEFAULT_NO');
            }else{
                $string = preg_replace("/[^0-9\.]/", '', $latest->subscription_no);
                $subscriptionNo = config('constants.SUBSCRIPTION_DEFAULT_PREFIX') . sprintf('%06d', $string+1);
            }

            $userPlanSubscription = new UserPlanSubscription();

            $userPlanSubscription->user_id = $user->id;
            $userPlanSubscription->plan_id = $plan->id;
            $userPlanSubscription->shop_process_id = $shop_process_id;
            $userPlanSubscription->subscription_no = $subscriptionNo;
            $userPlanSubscription->name = $plan->name;
            $userPlanSubscription->currency = $plan->currency;
            $userPlanSubscription->price = $plan->price;
            $userPlanSubscription->starts_at = $currentDateTime;
            $userPlanSubscription->ends_at = $plan->expired_date;

            $userPlanSubscription->save();
            
            //Update user table with plan history
            $user->plan_id = $plan->id;
            $user->plan_status = 1;
            $user->plan_ends_at = $plan->expired_date;
            $user->save();

            //assign role according to request
            if($role){
                $user->roles()->sync([$role->id], ['user_type' => 'App\Models\User']);
            }
            //Forgot / unset session for plan slug
            Session::forget('selectedPlanSlug');
        //}
            return view('auth.user-plan-purchase-success',compact('confirmation'));
        }

        if($dealSlug) 
        {
            $offer = Offer::where('slug',$dealSlug)->first();
            $offer->is_payment_buyer = 'Yes';
            $offer->shop_process_id = $shop_process_id;
            $offer->save();

             /* start find step code */
            $step_id = Session::get('deal_step_id');
            $offer_id = $offer->id;
            if($offer_id > 0 && $offer->is_payment_buyer == 'Yes' && isset($step_id) && $step_id > 0) 
            {
                $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];

                if(isset($all_tracking_steps) && $step_id > 0)
                {
                    $step_data_first =  $all_tracking_steps->where('id', $step_id)->first();
                    $step_links_ids = [];
                    
                    if(isset($step_data_first->step_links) && !is_null($step_data_first->step_links) && !empty($step_data_first->step_links))
                    {
                        $step_links_ids = json_decode($step_data_first->step_links);
                    }
            
                    if($step_links_ids && count($step_links_ids) > 0)
                    {
                        foreach($step_links_ids as $step_links_id) 
                        {
                            $step_name = $all_tracking_steps->where('id', $step_links_id)->first()->title_en;
                            $step_type = $all_tracking_steps->where('id', $step_links_id)->first()->step_type;

                            if($step_type == 'Buyer') {
                                $next_back_buyer_ids[]= (int) $step_links_id;
                            } else if($step_type == 'Seller'){
                                $next_back_seller_ids[]= (int) $step_links_id;
                            }
                        
                            $update_status_all_step_type = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $step_type)->update(['is_current' => 0, 'is_completed' => 1]);

                            $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $step_type)->where('title', $step_name)->orderBy('id', 'desc')->first();
                            
                            if(!$is_exist)
                            {
                                $is_exist = new OperationsLogs;
                            }
                            
                            $is_exist->operation_id = null;
                            $is_exist->title = $step_name;
                            $is_exist->is_current = 1;
                            $is_exist->is_completed = 1;
                            $is_exist->offer_id = $offer_id;
                            $is_exist->log_types = $step_type;
                            $is_exist->user_ip_address = \Request::userAgent();
                            $is_exist->user_device = \Request::ip();
                            $is_exist->completed_at = Carbon::now();
                            $is_exist->save();
                        }
                    }
                }
            }
            /* end find step code */
            Session::forget('selectedDealsSlug');
            Session::forget('deal_step_id');
            return redirect()->route('deals.details', [$dealSlug, 'buyer'])->with('success', 'Payment successfully done for this deal!');
        }

        if($dealMipoCommissionDealsSlug) 
        {
            $offer = Offer::where('slug', $dealMipoCommissionDealsSlug)->first();
            $offer->is_mipo_commission_payment = 'Yes';
            $offer->shop_process_id = $shop_process_id;
            $offer->save();

             /* start find step code */
            $step_id = Session::get('deal_step_mipo_id');
            $offer_id = $offer->id;
            if($offer_id > 0 && $offer->is_payment_buyer == 'Yes' && isset($step_id) && $step_id > 0) 
            {
                $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];

                if(isset($all_tracking_steps) && $step_id > 0)
                {
                    $step_data_first =  $all_tracking_steps->where('id', $step_id)->first();
                    $step_links_ids = [];
                    
                    if(isset($step_data_first->step_links) && !is_null($step_data_first->step_links) && !empty($step_data_first->step_links))
                    {
                        $step_links_ids = json_decode($step_data_first->step_links);
                    }
            
                    if($step_links_ids && count($step_links_ids) > 0)
                    {
                        foreach($step_links_ids as $step_links_id) 
                        {
                            $step_name = $all_tracking_steps->where('id', $step_links_id)->first()->title_en;
                            $step_type = $all_tracking_steps->where('id', $step_links_id)->first()->step_type;

                            if($step_type == 'Buyer') {
                                $next_back_buyer_ids[]= (int) $step_links_id;
                            } else if($step_type == 'Seller'){
                                $next_back_seller_ids[]= (int) $step_links_id;
                            }
                        
                            $update_status_all_step_type = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $step_type)->update(['is_current' => 0, 'is_completed' => 1]);

                            $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $step_type)->where('title', $step_name)->orderBy('id', 'desc')->first();
                            
                            if(!$is_exist)
                            {
                                $is_exist = new OperationsLogs;
                            }
                            
                            $is_exist->operation_id = null;
                            $is_exist->title = $step_name;
                            $is_exist->is_current = 1;
                            $is_exist->is_completed = 1;
                            $is_exist->offer_id = $offer_id;
                            $is_exist->log_types = $step_type;
                            $is_exist->user_ip_address = \Request::userAgent();
                            $is_exist->user_device = \Request::ip();
                            $is_exist->completed_at = Carbon::now();
                            $is_exist->save();
                        }
                    }
                }
            }
            /* end find step code */
            Session::forget('selectedMipoCommissionDealsSlug');
            Session::forget('deal_step_mipo_id');
            return redirect()->route('deals.details', [$dealMipoCommissionDealsSlug, 'buyer'])->with('success', 'Payment successfully done for this deal!');
        }
    }
    public function paymentCancel(Request $request,$shop_process_id){
        info('Cancel:'.$shop_process_id);
        info([$request->all()]);
        print_r($_POST);
        print_r($_GET);
    }
    public function paymentCard(Request $request,$shop_process_id){
        info('Card:'.$shop_process_id);
        info([$request->all()]);
        print_r($_POST);
        print_r($_GET);
    }
}
