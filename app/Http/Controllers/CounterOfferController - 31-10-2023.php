<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CounterOffer;
use App\Models\Offer;
use App\Models\OffersHistory;
use Carbon\Carbon;
use App\Models\OperationsLogs;
use App\Models\DealsContract;
use App\Models\OfferOperation;
use App\Models\BankDetails;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OfferRevert as NotificationsOfferRevert;
use App\Notifications\SendContractFileSellerAndBuyer as NotificationsSendContractFileSellerAndBuyer;
use App\Notifications\ReceivingCounterOfferInvestor as NotificationsReceivingCounterOfferInvestor;
use App\Notifications\ThirtyMinutesOfferExpiresInvestor as NotificationsThirtyMinutesOfferExpiresInvestor;
use App\Notifications\SignContractInvestor as NotificationsSignContractInvestor;
use App\Notifications\ReceivingCounterOfferBorrower as NotificationsReceivingCounterOfferBorrower;
use App\Notifications\SignContractBorrower as NotificationsSignContractBorrower;
use App\Notifications\PayComissionInvestor as NotificationsPayComissionInvestor;
use App\Notifications\TransferFundsToSeller as NotificationsTransferFundsToSellerInvestor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Notifications\SignContractOtp as NotificationsSignContractOtp;
use App\Models\UserContractSing;
use App\Models\userContractSingOtp;
use App\Models\Issuer;

class CounterOfferController extends Controller
{
    
    public function ajaxSaveCounterOffer(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required',
            'counter_offer_hour_day' => 'required',
            'counter_offer_payment_method' => ['required', Rule::in(config('constants.PREFERRED_MODE'))],
            'counter_offer_amount' => 'required',
            'counter_offer_time' => 'required',
        ]);
        
        if($request->ajax())
        {
            $default_offer_time = config('constants.DEFAULT_OFFER_TIME');
            $offer_id = $request->get('offer_id');
            $expires_at_time = $request->get('counter_offer_time', 0);
            $offer_day_hour = $request->get('counter_offer_hour_day');
            $counter_offer_amount = $request->get('counter_offer_amount');

            $offer_query = Offer::with('operations')->where('id', $offer_id)->first();

            $offer_with_operation_amount = $offer_query->operations->sum('amount');
            
            if( (int) $counter_offer_amount > $offer_with_operation_amount || is_null($offer_query)) {
                $response = [
                    'status' => false,
                    'message' => 'Counter offer amount must less than operation amount',
                    'data' => []
                ];
                return response()->json($response);
            }

            DB::beginTransaction();
            try {
                    $expires_at = Carbon::now();
                    if(!is_null($expires_at_time) && $expires_at_time > 0) {
                        if($offer_day_hour == 'day') {
                            $expires_at = Carbon::now()->addDay($expires_at_time);
                        } else if($offer_day_hour == 'hour') {
                            $expires_at = Carbon::now()->addHour($expires_at_time);
                        } else {
                            $expires_at= Carbon::now()->addHour($default_offer_time);
                        }
                    } else {
                            $expires_at = Carbon::now()->addHour($default_offer_time);
                    }
                    $update = Offer::where('id', $offer_id)->first();
                    $update->preferred_payment_method = $request->get('counter_offer_payment_method');
                    $update->offer_status = 'Counter';
                    $update->expires_at = $expires_at;
                    $update->save();
                    
                    OffersHistory::create_offers_history($update, $counter_offer_amount);

                    $save = new CounterOffer();
                    $save->offer_id = $request->get('offer_id');
                    $save->preferred_payment_method = $request->get('counter_offer_payment_method');
                    $save->reminder_on_expire = $request->get('reminder_on_expire','0');
                    $save->expires_at = $expires_at;
                    $save->amount = $counter_offer_amount;
                    $save->save();
                    DB::commit();

                    $user_obj = app('common')->getUserEmail($update->buyer_id);
                    
                    if($user_obj->as_investor == '1') {
                        Notification::send($user_obj, new NotificationsReceivingCounterOfferInvestor(app()->getLocale()));
                        app('common')->addLogs('send email user receiving a counter offer investor', $user_obj->id);

                        Notification::send($user_obj, new NotificationsThirtyMinutesOfferExpiresInvestor(app()->getLocale()));
                        app('common')->addLogs('send email user 30 minutes before offer expires investor', $user_obj->id);
                    }

                    if($user_obj->as_borrower == '1') {
                        Notification::send($user_obj, new NotificationsReceivingCounterOfferBorrower(app()->getLocale()));
                        app('common')->addLogs('send email user receiving a counter offer borrower', $user_obj->id);
                    }

                    $result_offer_operations = app('offer')->offerByOfferOperation(['offer_id' => $offer_id]);

                    if($result_offer_operations) {
                        foreach($result_offer_operations as $offer_operation) {
                            OperationsLogs::operationsAddLogsTitle($offer_operation->operation_id, "Offer Counter",  $offer_id); 
                        }
                    }
                    $response = [
                        'status' => true,
                        'message' => 'Counter Offer Sent Successfully',
                        'data' => []
                    ];
                } catch (\Throwable $th) {
                        DB::rollBack();
                        $response = [
                            'success' => 0,
                            'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
                        ];
                }
                return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxSaveOfferStatus(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required',
            'offer_status' => 'required|in:Pending,Approved,Rejected,Counter,Revert'
        ]);

        if($request->ajax())
        {
            $notifications_operation = config('constants.NOTIFICATIONS_TYPES.OFFERS');

            $offer_status = $request->get('offer_status');
            $offer_id = $request->get('offer_id');
            $update = Offer::where('id', $offer_id)->first();
            
            if($update)
            {
                $req_param['offer_type'] = $update->offer_type;
                $req_param['offer_operations'] = app('offer')->offerByOfferOperation(['offer_id' => $offer_id]);

                if($offer_status == 'Revert') {
                    $msg = "Offer revert back successfully.";
                    if(isset($req_param['offer_operations'])) {
                        foreach ($req_param['offer_operations'] as $key => $offer_operation) {
                            OperationsLogs::operationsAddLogsTitle($offer_operation->operation_id, "Offer $offer_status",  $offer_id);
                            OfferOperation::where('operation_id', $offer_operation->operation_id)->where('offer_id', $offer_id)->update(['is_offered' => '2']); // 2 is delete Offer Operation revert
                        }
                    }
                    $notifications_operation = config('constants.NOTIFICATIONS_TYPES.OFFERS');
                    if($notifications_operation['Revert']) {
                        $operation_id = ($req_param['offer_operations']) ? $req_param['offer_operations']->first()?->operation_id : null;
                        $operation = app('operation')->getOperationByIdWithSeller($operation_id);
                        Notification::send($operation->seller, new NotificationsOfferRevert($operation->operation_number));
                    }
                    $update->delete();
                } else {
                    if($offer_status == 'Approved') {
                        $msg = "Offer approved successfully.";
                        $req_param['operation_id'] = OfferOperation::where('offer_id', $offer_id)->select('operation_id')->pluck('operation_id')->toArray();
                        if($update->offer_status == 'Counter' && $offer_status == 'Approved')
                        { 
                            /* Offer For Recalculation */
                            if($update->buyer_id == Auth()->user()->id) {
                                $req_param['offer_type'] = $update->offer_type;
                                $req_param['offer_amount'] = CounterOffer::where('offer_id', $offer_id)->select('amount')->orderBy('id', 'DESC')->first()->amount;
                                $req_param['retention'] =  $update->retention;
                                // $req_param['operation_id'] = OfferOperation::where('offer_id', $offer_id)->select('operation_id')->pluck('operation_id')->toArray();
                                $req_param['is_mipo_plus'] = ($update->is_mipo_plus == 'Yes') ? 'true' : 'false';

                                $calc_res =  app('common')->calculationForOffer($req_param, 'update_offer');
                            
                                $update->amount  = $req_param['offer_amount'];
                                $update->retention  = $calc_res['retention'];
                                $update->mipo_commission  = $calc_res['mipo_commission'];
                                $update->mipo_plus_commission  = $calc_res['mipo_plus_commission'];
                                $update->net_profit = $calc_res['net_profit'];
                                $update->is_mipo_plus = $calc_res['is_mipo_plus'];
                            }
                        }

                        $update->offer_status = $offer_status;
                        $update->save();

                        if(isset($req_param['operation_id']) && count($req_param['operation_id']) > 0) {
                            foreach ($req_param['operation_id'] as $key => $operation_id) {
                                OfferOperation::where('operation_id', $operation_id)->update(['is_offered' => '1']);
                            }
                        }

                        /* Add logs offer status  Approved */
                        app('common')->updateUserLevel($offer_id);
                        
                        if(isset($req_param['offer_operations'])) {
                            foreach ($req_param['offer_operations'] as $key => $offer_operation) {
                                
                                OperationsLogs::operationsAddLogs(1, '1', 'Seller', $offer_id);

                                // OperationsLogs::operationsAddLogs(2, '0', 'Buyer', $offer_id);
                            }
                        }
                    } else {
                        if($offer_status == 'Rejected') {
                            $msg = "Offer rejected successfully.";
                        }
                        $update->offer_status = $offer_status;
                        $update->save();
                    }
                }
                
                $offer_result = Offer::where('id', $offer_id)->with('operations:id,seller_id,operation_number')->where('offer_status', 'Approved')->select('id', 'offer_status', 'buyer_id')->first();
                
                if($offer_result) {

                        $buyer_obj = app('common')->getUserEmail($offer_result->buyer_id);

                    // if($user_obj->as_investor == '1') {
                        Notification::send($buyer_obj, new NotificationsSignContractInvestor(app()->getLocale()));
                        app('common')->addLogs('send email investor an offer has been approved already asking to sign contract', $buyer_obj->id);

                        Notification::send($buyer_obj, new NotificationsPayComissionInvestor(app()->getLocale()));
                        app('common')->addLogs('send email investor please pay comission at the moment + at 24 hrs', $buyer_obj->id);

                        Notification::send($buyer_obj, new NotificationsTransferFundsToSellerInvestor(app()->getLocale()));
                        app('common')->addLogs('send email investor please transfer funds to seller at moment and at 24 hrs', $buyer_obj->id);
                        
                    // }

                    // if($user_obj->as_borrower == '1') {
                        
                        // send seller mail
                        $seller_obj = app('common')->getUserEmail($offer_result->operations->first()->seller_id);

                        Notification::send($seller_obj, new NotificationsSignContractBorrower(app()->getLocale()));
                        app('common')->addLogs('send email borrower an offer has been approved with steps to follow for seller asking to sign document', $seller_obj->id);
                    // }
                }

                $response = [
                    'status' => true,
                    'message' => $msg,
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No offer found.',
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxConfirmOfferPdf(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required',
            'offer_status' => 'required|in:Approved'
        ]);

        try {
            $offer_status = $request->get('offer_status');
            $offer_id = $request->get('offer_id');
            $otp_resend = $request->get('otp_resend', 'false');
            
            $user_login_id = Auth()->user()->id;
            
            $result = app('offer')->offerContractDetailsById(['offer_id' => $offer_id]);
            if(!$result) {
                $response = [
                    'status' => false,
                    'message' => 'No record found',
                    'data' => []
                ];
            }

            if($result->preferred_payment_method !='Cash') {

                $is_user_bank = BankDetails::where('user_id', $user_login_id)->whereIn('payment_options', ['eWallet', 'Bank'])->where('is_active', 'Yes')->count();
            
                if($is_user_bank == 0) {
        
                    $response = [
                        'status' => false,
                        'message' => 'Please add bank details',
                        'data' => []
                    ];
                    return response()->json($response);
                }
            }
            
            $offer_id = $result->id;

            $is_user_company = Auth()->user()->is_user_company;
            $company_owner_name_id = Auth()->user()->parent_id; // company_owner_name_id
            $issuer_id = Auth()->user()->issuer_id; // as company id

            $user_type = 'seller';
            if($user_login_id == $result->buyer_id) {
            $user_type = 'buyer';
            }

            $user_contract_sing  = [];
            $user_contract_sing_compnay = [];
            if($is_user_company > 0 && $issuer_id > 0) {
            
                $user_contract_sing = UserContractSing::select('id', 'user_id', 'name')->where('user_id', '!=', $company_owner_name_id)->where('issuer_id', $issuer_id)->where('is_active', '1')->get();

                if(($user_type == 'seller' || $user_type == 'buyer') && $user_contract_sing->count() > 0) {

                    foreach ($user_contract_sing as $key => $user_contract_sing_val) {
                        $save = userContractSingOtp::where('user_id', $user_contract_sing_val->user_id)->where('offer_id', $offer_id)->first();
                        if(is_null($save)) {
                            $otp = app('common')->otpGenerate();
                            $save = new userContractSingOtp();
                            $save->user_id = $user_contract_sing_val->user_id;
                            $save->user_contract_sing_id = $user_contract_sing_val->id;
                            $save->offer_id = $offer_id;
                            $save->otp = $otp;
                            $save->user_type = $user_type;
                            $save->is_company = $is_user_company;
                            $save->save();
                            
                            $user_obj = app('common')->getUserEmail($user_contract_sing_val->user_id);
                            Notification::send($user_obj, new NotificationsSignContractOtp(app()->getLocale(), $otp, 'user contract'));
                        }     
                    }
                }
            }
     
            $otp = app('common')->otpGenerate();
            $save_deals_contract = DealsContract::where('offer_id', $offer_id)->first();
    
            if(is_null($save_deals_contract)) {
                $save_deals_contract = new DealsContract;
            } else {
                $save_deals_contract = $save_deals_contract;   
            }
    
            if($user_login_id == $result->buyer_id && $user_type = 'buyer') {
                if($otp_resend == "true") {
                    $otp = $save_deals_contract->buyer_otp;
                } else {
                    $save_deals_contract->buyer_otp = $otp;
                }
                $buyer_obj = app('common')->getUserEmail($result->buyer_id);
                Notification::send($buyer_obj, new NotificationsSignContractOtp(app()->getLocale(), $otp, 'buyer'));
                app('common')->addLogs('send email investor sign contract Otp', $buyer_obj->id);
    
            } else {
                if($user_type == 'seller' && $user_login_id!='') {
                    if($otp_resend == "true") {
                        $otp = $save_deals_contract->seller_otp;
                    } else {
                        $save_deals_contract->seller_otp = $otp;
                    }
                    $seller_obj = app('common')->getUserEmail($user_login_id);
                    Notification::send($seller_obj, new NotificationsSignContractOtp(app()->getLocale(), $otp, 'seller'));
                    app('common')->addLogs('send email borrower sign contract Otp', $seller_obj->id);
                }
            }
            $save_deals_contract->offer_id = $offer_id; 
            $save_deals_contract->save();
            
            if($otp_resend == 'false') {
                $data['deals_contract_id'] = $result->slug;
                $data['deals_id'] = $result->id;
                $data['user_type'] = $user_type;
                $data['offer'] = $result;
                $data['otp'] = $otp;
                $data['is_user_company'] = $is_user_company;
                $data['user_contract_sing'] = $user_contract_sing;

                if($is_user_company > 0 && $issuer_id > 0) {
                    $data['user_contract_sing_otps'] = userContractSingOtp::whereHas('user_contract_sing', function($qry) use ($issuer_id){
                        $qry->where('issuer_id', $issuer_id);
                    })->with('user:id,issuer_id,name,email', 'user.issuer:id,ruc_text_id,ruc_code_optional,company_name,commercial_name')
                    ->where('offer_id', $offer_id)
                    ->where('user_type', $user_type)
                    ->get();

                $data['company_details'] = Issuer::where('id', $issuer_id)->select('id', 'company_name', 'commercial_name', 'ruc_text_id', 'ruc_code_optional')->first();
            } else {
                $data['user_contract_sing_otps'] = [];
                $data['company_details'] = null;
                }
            
                if($result->operations->first()->operation_type == 'Invoice') {
                    $dhtml = view('operations.ajax.ajax-confrim-offer-contract-invoice', $data)->render();
                } else {
                    $dhtml = view('operations.ajax.ajax-confrim-offer-contract-cheque-contract-other', $data)->render();
                }
                
                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml, 'otp' => $otp, 'is_user_company' => $is_user_company, 'user_contract_sing' => $user_contract_sing_compnay ]
                ];
            } else if($otp_resend== 'true')  {
                $response = [
                    'status' => true,
                    'message' => 'OTP Resend Successfully',
                    'otp' => $otp,
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'something went wrong please try again',
                    'data' => []
                ];
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function ajaxConfirmOfferSave(Request $request)
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
    
        if($request->ajax())
        {
            $validated = $request->validate([
                'deals_id' => 'required',
                'deals_contract_id' => 'required',
                'deals_contract_otp' => 'required|min:3',
                'deals_contract_verify' => 'required',
                'deals_contract_status' => 'required|in:Approved'
            ]);

            DB::beginTransaction();
            try {
                $notifications_operation = config('constants.NOTIFICATIONS_TYPES.OFFERS');

                $offer_status = $request->get('deals_contract_status');
                $offer_id = $request->get('deals_id');
                $offer_slug = $request->get('deals_contract_id');
                $deals_contract_otp = $request->get('deals_contract_otp');

                $user_login_id = Auth()->user()->id;

                $deals_contract_name = Auth()->user()->name;
                $deals_contract_ids = Auth()->user()?->issuer?->ruc_text_id ?? '';
                $deals_contract_phone = Auth()->user()->phone_number;

                $update = Offer::where('id', $offer_id)->where('slug', $offer_slug)->first();

                if($update && $user_login_id)
                {
                    $offer_id = $update->id;
                    $user_type = 'seller';
                    if($user_login_id == $update->buyer_id) {
                    $user_type = 'buyer';
                    }
                
                    $deals_status = "Pending";
                    $save_deals_contract = DealsContract::where('offer_id', $offer_id)->first();
                    if(is_null($save_deals_contract)) {
                        $save_deals_contract = new DealsContract;
                    } else {
                        $deals_status = "Inprogress";
                        $save_deals_contract = $save_deals_contract;   
                    }
                    $msg = "Contract Signed Successfully";
                    
                    $otp_verify = false;

                    if($user_type == 'seller' && ($save_deals_contract->seller_otp == $deals_contract_otp ||  config('constants.ALL_OTP_VERIFY') == $deals_contract_otp)) {
                        $otp_verify = true;
                        $save_deals_contract->offer_id = $offer_id; 
                        $save_deals_contract->seller_id = $user_login_id;
                        $save_deals_contract->seller_signature_name = $deals_contract_name;
                        $save_deals_contract->seller_id_no = $deals_contract_ids;
                        $save_deals_contract->seller_phone_number = $deals_contract_phone;
                        $save_deals_contract->seller_otp_verify = 'Yes';
                        $save_deals_contract->seller_file  = null;
                        $save_deals_contract->seller_ip = app('common')->getUserIP();
                        $save_deals_contract->seller_date_time  = date('Y-m-d H:i:s');
                        
                        $update->is_seller_deals_contract = 'Yes';
                        $update->save();
                        app('common')->addLogs('Seller Contract Signed Successfully', $user_login_id);

                        /* ADD STEP DEALS SELLER */
                        $step_name_req = config('constants.SELLER_SIGN_CONTRACT_FORWARD_DEAL_TITLE');
                        $log_type = "Seller";

                        $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->update(['is_current' => 0, 'is_completed' => 1]);

                        $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->where('title', $step_name_req)->orderBy('id', 'desc')->first();
                        
                        if(!$is_exist)
                        {
                            $is_exist = new OperationsLogs;
                        }
                        $is_exist->operation_id = null;
                        $is_exist->title = $step_name_req;
                        $is_exist->is_current = 1;
                        $is_exist->is_completed = 1;
                        $is_exist->offer_id = $offer_id;
                        $is_exist->log_types = $log_type;
                        $is_exist->user_ip_address = \Request::userAgent();
                        $is_exist->user_device = \Request::ip();
                        $is_exist->completed_at = Carbon::now();
                        $is_exist->save();
                        /* END STEP DEALS SELLER */
                        DB::commit();

                    } else if($user_type == 'buyer' && ($save_deals_contract->buyer_otp == $deals_contract_otp || config('constants.ALL_OTP_VERIFY') == $deals_contract_otp)) {
                        $otp_verify = true;
                        $save_deals_contract->offer_id = $offer_id; 
                        $save_deals_contract->buyer_id = $user_login_id;
                        $save_deals_contract->buyer_signature_name = $deals_contract_name;
                        $save_deals_contract->buyer_id_no = $deals_contract_ids;
                        $save_deals_contract->buyer_phone_number = $deals_contract_phone;
                        $save_deals_contract->buyer_otp_verify = 'Yes';
                        $save_deals_contract->buyer_file = null;
                        $save_deals_contract->buyer_ip = app('common')->getUserIP();
                        $save_deals_contract->buyer_date_time  = date('Y-m-d H:i:s');

                        $update->is_buyer_deals_contract = 'Yes';
                        $update->save();
                        app('common')->addLogs('Buyer Contract Signed Successfully', $user_login_id);

                        /* ADD STEP DEALS BUYER */
                        $step_name_req = config('constants.BUYER_SIGN_CONTRACT_FORWARD_DEAL_TITLE');
                        $log_type = "Buyer";

                        $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->update(['is_current' => 0, 'is_completed' => 1]);

                        $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->where('title', $step_name_req)->orderBy('id', 'desc')->first();
                        
                        if(!$is_exist)
                        {
                            $is_exist = new OperationsLogs;
                        }
                        $is_exist->operation_id = null;
                        $is_exist->title = $step_name_req;
                        $is_exist->is_current = 1;
                        $is_exist->is_completed = 1;
                        $is_exist->offer_id = $offer_id;
                        $is_exist->log_types = $log_type;
                        $is_exist->user_ip_address = \Request::userAgent();
                        $is_exist->user_device = \Request::ip();
                        $is_exist->completed_at = Carbon::now();
                        $is_exist->save();
                        /* ADD STEP DEALS BUYER */
                        DB::commit();
                    }

                    if($otp_verify == false) {
                        $response = [
                            'status' => false,
                            'message' => 'OTP Invalid',
                            'data' => []
                        ];
                        return response()->json($response);
                    }

                    $save_deals_contract->save();

                /* create contract pdf */
                if(!empty($save_deals_contract->buyer_id) && !empty($save_deals_contract->seller_id))
                {
                    $deals_contract = DealsContract::where('offer_id', $offer_id)->with('seller', 'seller.issuer', 'buyer', 'buyer.issuer')->first();
        
                    $result = app('offer')->offerContractDetailsById(['offer_id' => $offer_id]);

                    if(!$result) {
                        $response = [
                            'status' => false,
                            'message' => 'No record found',
                            'data' => []
                        ];
                        return response()->json($response);
                    }
                    
                    $offer_id = $result->id;
                    
                    $user_type = 'seller';
                    if($user_login_id == $result->buyer_id) {
                    $user_type = 'buyer';
                    }

                    $data['user_type'] = $user_type;
                    $data['offer'] = $result;
                    $data['documents'] = $result->operations->pluck('documents')->flatten();
                    $data['supportingAttachments'] = $result->operations->pluck('supportingAttachments')->flatten();
                    $data['buyer_sing_file'] = null;
                    $data['seller_sing_file'] = null;
                    $data['deals_contract'] = $deals_contract;
                    $data['user_contract_sing_otps'] = userContractSingOtp::
                        with('user:id,issuer_id,name,email', 'user.issuer:id,ruc_text_id,ruc_code_optional,company_name,commercial_name')
                        ->where('offer_id', $offer_id)
                        ->get();
                    
                    $fileName = $result->id.date('Ymdhis').".pdf";
                    

                    if($result->operations->first()->operation_type == 'Invoice') {
                        $pdf = Pdf::loadView('operations.pdf.confrim-offer-contract-invoice', $data);
                    } else {
                        $pdf = Pdf::loadView('operations.pdf.confrim-offer-contract-cheque-contract-other', $data);
                    }
                
                    $filePath = 'deals/' . $offer_id . '/contract/pdf/';

                    $content = $pdf->download()->getOriginalContent();
                    
                    Storage::put($filePath.$fileName, $content);

                    $save_deals_contract->deals_contract_file = $filePath.$fileName;
                    $save_deals_contract->save();
                    DB::commit();
                    
                    /* send Buyer */
                    $attach  = storage_path('app/'.$filePath.$fileName);
                    
                    $user_obj = app('common')->getUserEmail($save_deals_contract->buyer_id);
                    Notification::send($user_obj, new NotificationsSendContractFileSellerAndBuyer($attach));
                    
                    /* send Seller */
                    $user_obj = app('common')->getUserEmail($save_deals_contract->seller_id);
                    Notification::send($user_obj, new NotificationsSendContractFileSellerAndBuyer($attach));
                }

                $response = [
                    'status' => true,
                    'message' => $msg,
                    'data' => []
                ];

            } else {
                $response = [
                    'status' => false,
                    'message' => 'No offer found. successfully',
                    'data' => []
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => false,
                'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                'data' => []
            ];
        }
        return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
}
