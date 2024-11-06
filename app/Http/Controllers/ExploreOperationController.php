<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Offer;
use App\Models\User;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Models\OfferOperation;
use App\Models\OffersHistory;
use App\Models\Rating;
use App\Models\OperationsLogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OfferAddRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OfferReceived as NotificationsOfferReceived;
use App\Notifications\FirstBidInvestor as NotificationsFirstBidInvestor;
use App\Notifications\SecondBidInvestor as NotificationsSecondBidInvestor;

class ExploreOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $all_tags = \Spatie\Tags\Tag::get()->pluck('name', 'id')->toArray();
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $investor_commission = app('common')->userPlan()->investor_commission;
        $mipo_commission = app('common')->userPlan()->mipo_commission;

        return view('explore-operations.index', ['currency_symblos' => $currency_symblos, 'all_tags' => $all_tags, 'investor_commission' => $investor_commission, 'mipo_commission' => $mipo_commission]);
    }

    public function ajaxLoadMoreExploreOperations(Request $request)
    {
        if($request->ajax())
        {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');
                $page = $request->input('page');
                $sort_column = $request->get('sort_column', 'id');
                $sort_type = $request->get('sort_type', 'DESC');
                if($sort_column == 'amount_asc'){
                    $sort_column = 'amount';
                    $sort_type = 'ASC';
                }
                if($sort_column == 'amount_desc') {
                    $sort_column = 'amount';
                    $sort_type = 'DESC';
                }
                
                $all_request_param = ($request->all() + ['sort_column' => $sort_column, 'sort_type' => $sort_type]);
            
                $operations = app('explore')->getAllExplore($all_request_param);

                $dhtml = view('explore-operations.ajax.ajax-explore-operations-list', [
                    'operations' => $operations, 'currency_symblos' => $currency_symblos, 'buyer_id' => Auth()->user()->id,
                    'current_page' => $operations->currentPage(), 'last_page' => $operations->lastPage(), 'has_more_pages' => $operations->hasMorePages()
                    ])->render();

                $dhtml_mobile = view('explore-operations.ajax.ajax-explore-operations-list-mobile', [
                        'operations' => $operations, 'currency_symblos' => $currency_symblos, 'buyer_id' => Auth()->user()->id,
                        'current_page' => $operations->currentPage(), 'last_page' => $operations->lastPage(), 'has_more_pages' => $operations->hasMorePages()
                        ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml, 'dhtml_mobile' => $dhtml_mobile]
                ];
                
            } catch (\Throwable $th) {
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
    
    public function exploreOperationDetail($slug)
    {
        $result = Operation::with(['seller' => function($qry){
            $qry->select('id', 'slug', 'name', 'account_type', 'security_level', 'user_level', 'address_verify','address_authorise_name', 'phone_number','profile_image', 'issuer_id');
            $qry->withAvg('ratings', 'rating_number')->withCount('ratings');
            $qry->with('issuer:id,company_name,slug,ruc_text_id,ruc_code_optional');
        }, 'issuer' => function($qry){
            $qry->select('id','slug', 'company_name', 'bcp','inforconf', 'infocheck', 'criterium', 'verified_address', 'registry_in_mipo', 'tradename', 'ruc_text_id', 'ruc_code_optional', 'commercial_name', 'issuers_image')->withAvg('ratings', 'rating_number')->withCount('ratings');;
        }, 'tags', 'supportingAttachments', 'references', 'documents', 
            'offers' => fn($qry) => $qry->whereNotIn('offer_status', ['Approved', 'Completed'])
            ->where('buyer_id', Auth()->user()->id)->select('*')->with('counter_offers'),
        ])
        ->where('slug', $slug)->first();
        
        if($result) {
            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $currency_type = config('constants.CURRENCY_TYPE');
            $investor_commission = app('common')->userPlan()->investor_commission;
            $mipo_commission = app('common')->userPlan()->mipo_commission;
            
            return view('explore-operations.details', ['result' => $result, 'currency_symblos' => $currency_symblos, 'buyer_id' => Auth()->user()->id, 'investor_commission' => $investor_commission, 'mipo_commission' => $mipo_commission, 'currency_type' => $currency_type]);
        } else {
            return redirect()->route('explore-operations.index');
        }
    }

    public function ajaxGetExploreOperationsGroup(Request $request)
    {
        if($request->ajax())
        {
            $operations_ids = $request->get('operations_ids');
            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $preferred_currency = $request->get('preferred_currency', 'USD');
            
            $operations = app('explore')->getExploreOperationsGroup($request->all());
            
            if($operations)
            {
                $total_seller_ids = $operations->pluck('seller_id')->unique()->implode(',');
                $investor_commission = app('common')->userPlan()->investor_commission;
                $mipo_commission = app('common')->userPlan()->mipo_commission;

                $dhtml = view('explore-operations.ajax.ajax-explore-operations-group', ['operations' => $operations, 'currency_symblos' => $currency_symblos, 'total_seller_ids' => $total_seller_ids, 'currency_name' => $preferred_currency, 'currency_sign' => $currency_symblos[$preferred_currency], 'investor_commission' => $investor_commission, 'mipo_commission' => $mipo_commission])->render();
                $response = [
                    'status' => true,
                    'currency' => $preferred_currency,
                    'message' => '',
                    'record' => ($operations->count() > 0 ) ? true : false,
                    'data' => ['dhtml' => $dhtml]
                ];
            } else {
                $response = [
                    'status' => false,
                    'currency' => config('constants.CURRENCY_TYPE')[1],
                    'message' => 'No ' .$preferred_currency . ' Record found',
                    'data' => ''
                ]; 
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
    /*
     this () use  to save offer  signle and group 
     date::16/02/2023
    */
    public function ajaxSaveGroupOffer(OfferAddRequest $request)
    {
        if($request->ajax())
        {
        DB::beginTransaction();
        try {
                $default_offer_time = config('constants.DEFAULT_OFFER_TIME');
                $offer_type = $request->get('offer_type');
                $operation_id = $request->get('operation_id', '');
                $seller_id = $request->get('seller_id', '');
                $operation_amount = $request->get('operation_amount', '');
                $retention = $request->get('retention');
                $preferred_payment_method = $request->get('deal_mode');
                $expires_at = $request->get('offer_till', $default_offer_time);
                $offer_amount = $request->get('offer_amount');
                $operation_ids = $request->get('operation_id');
                $offer_day_hour = $request->get('offer_day_hour', 'hour');
                
                $request_param = $request->all();
                $calc_res =  app('common')->calculationForOffer($request_param);
            
                $save = new Offer();
                $save->buyer_id = Auth()->user()->id;
                $save->preferred_payment_method  = $preferred_payment_method;
                $save->amount  = $offer_amount;
                $save->retention  = $calc_res['retention'];
                $save->mipo_commission  = $calc_res['mipo_commission'];
                $save->mipo_plus_commission  = $calc_res['mipo_plus_commission'];
                $save->net_profit = $calc_res['net_profit'];
                $save->is_mipo_plus = $calc_res['is_mipo_plus'];

                if(!is_null($expires_at) && $expires_at > 0) {
                    if($offer_day_hour == 'day') {
                        $save->expires_at = Carbon::now()->addDay($expires_at);
                    } else if($offer_day_hour == 'hour') {
                        $save->expires_at = Carbon::now()->addHour($expires_at);
                    } else {
                        $save->expires_at = Carbon::now()->addHour($default_offer_time);
                    }
                } else {
                    $save->expires_at = Carbon::now()->addHour($default_offer_time);
                }
                
                $save->offer_status  = 'Pending';
                $save->offer_type  = $offer_type;
                $save->save();

                $total_offer_by_user = Offer::where('buyer_id', Auth()->user()->id)->count();

                if($total_offer_by_user == 1) {
                    $user_obj = app('common')->getUserEmail(Auth()->user()->id);
                    if($user_obj->as_investor == '1') {
                        Notification::send($user_obj, new NotificationsFirstBidInvestor(app()->getLocale()));
                        app('common')->addLogs('send email user first bid investor', $user_obj->id);
                    }
                }

                if($total_offer_by_user == 2) {
                    $user_obj = app('common')->getUserEmail(Auth()->user()->id);
                    if($user_obj->as_investor == '1') {
                        Notification::send($user_obj, new NotificationsSecondBidInvestor(app()->getLocale()));
                        app('common')->addLogs('send email user second bid investor', $user_obj->id);
                    }
                }


                OffersHistory::create_offers_history($save);
                
                $offer_id = $save->id;

                if($offer_id > 0 ) {

                    if($offer_type == 'Group'){
                        $operation_forms = $request->get('operation_form', []);
                        if($operation_ids && is_array($operation_ids) && is_array($operation_forms)){
                            foreach($operation_forms as $operation_form){
                                $operation_id = $operation_form['operaion_id'];
                                if(in_array($operation_id, $operation_ids))
                                {
                                    $save_offer_operation = new OfferOperation();
                                    $save_offer_operation->offer_id	 = $offer_id;
                                    $save_offer_operation->operation_id	= $operation_id;
                                    $save_offer_operation->offer_retention	= null;
                                    $save_offer_operation->offer_deal_mode	= null;
                                    $save_offer_operation->offer_time	= null;
                                    $save_offer_operation->offer_time_type	= $offer_day_hour;
                                    $save_offer_operation->offer_amount	= null;
                                    $save_offer_operation->offer_mipo_plus	= $calc_res['is_mipo_plus'];
                                    $save_offer_operation->save();

                                    // OperationsLogs::operationsAddLogs($operation_id, 4, '0', 'Seller', $offer_id);

                                    // OperationsLogs::operationsAddLogs($operation_id, 1, '0', 'Buyer', $offer_id);
                                }
                            }
                        }
                    }

                    if($offer_type == 'Single'){
                        $save_offer_operation = new OfferOperation();
                        $save_offer_operation->offer_id	 = $offer_id;
                        $save_offer_operation->operation_id	= $operation_ids;
                        $save_offer_operation->offer_retention	= null;
                        $save_offer_operation->offer_deal_mode	= null;
                        $save_offer_operation->offer_time = null;
                        $save_offer_operation->offer_time_type = $offer_day_hour;
                        $save_offer_operation->offer_amount	= null;
                        $save_offer_operation->offer_mipo_plus	= $calc_res['is_mipo_plus'];
                        $save_offer_operation->save();

                        // OperationsLogs::operationsAddLogs($operation_ids, 4, '0', 'Seller', $offer_id);

                        // OperationsLogs::operationsAddLogs($operation_ids, 1, '0', 'Buyer', $offer_id);
                    }

                    OperationsLogs::operationsAddLogs(1, '0', 'Buyer', $offer_id);
                }
                try {
                    $notifications_operation = config('constants.NOTIFICATIONS_TYPES.OFFERS');
                    if($offer_id > 0) {
                       
                        if($offer_type == 'Single' && $notifications_operation['Received']) {

                            $operation = app('operation')->getOperationByIdWithSeller($operation_id);
                          
                            Notification::send($operation->seller, new NotificationsOfferReceived($operation->operation_number));
                            
                        } else if($offer_type == 'Group' && $notifications_operation['Received']) {
                                
                            $operation = app('operation')->getOperationByIdsWithSeller($operation_ids);

                            Notification::send($operation->first()->seller, new NotificationsOfferReceived($operation->pluck('operation_number')->implode(',')));

                        }
                    }
                } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                        'data' => []
                    ];
                    
                    return response()->json($response);
                }

                $response = [
                    'status' => true,
                    'message' => __('Offer sent successfully'),
                    'data' => []
                ];
            DB::commit();
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

    public function ajaxSaveGroupOffer_old(OfferAddRequest $request)
    {
        dd($request->all());
        if($request->ajax())
        {
        DB::beginTransaction();
        try {
            $default_offer_time = config('constants.DEFAULT_OFFER_TIME');
            $offer_type = $request->get('offer_type');
            $operation_id = $request->get('operation_id', '');
            $seller_id = $request->get('seller_id', '');
            $operation_amount = $request->get('operation_amount', '');
                $retention = $request->get('retention');
                $preferred_payment_method = $request->get('deal_mode');
                $expires_at = $request->get('offer_till', $default_offer_time);
                $offer_amount = $request->get('offer_amount');
                $operation_ids = $request->get('operation_id');
                $offer_day_hour = $request->get('offer_day_hour', 'hour');
                
                $request_param = $request->all();
                $calc_res =  app('common')->calculationForOffer($request_param);

                $save = new Offer();
                $save->buyer_id  =  Auth()->user()->id;
                $save->preferred_payment_method  = $preferred_payment_method;
                $save->amount  = $offer_amount;
                $save->retention  = $calc_res['retention'];
                $save->mipo_commission  = $calc_res['mipo_commission'];
                $save->mipo_plus_commission  = $calc_res['mipo_plus_commission'];
                $save->net_profit = $calc_res['net_profit'];
                $save->is_mipo_plus = $calc_res['is_mipo_plus'];

                if(!is_null($expires_at) && $expires_at > 0) {
                    if($offer_day_hour == 'day') {
                        $save->expires_at = Carbon::now()->addDay($expires_at);
                    } else if($offer_day_hour == 'hour') {
                        $save->expires_at = Carbon::now()->addHour($expires_at);
                    } else {
                        $save->expires_at = Carbon::now()->addHour($default_offer_time);
                    }
                } else {
                    $save->expires_at = Carbon::now()->addHour($default_offer_time);
                }
                
                $save->offer_type  = $offer_type;
                $save->save();

                $offer_id = $save->id;

                if($offer_type == 'Group'){
                    $operation_forms = $request->get('operation_form', []);
                    if($operation_ids && is_array($operation_ids) && is_array($operation_forms)){
                        foreach($operation_forms as $operation_form){
                            $operation_id = $operation_form['operaion_id'];
                            if(in_array($operation_id, $operation_ids))
                            {
                                $save_offer_operation = new OfferOperation();
                                $save_offer_operation->offer_id	 = $offer_id;
                                $save_offer_operation->operation_id	= $operation_id;
                                $save_offer_operation->offer_retention	= $operation_form['operaion_retention'];
                                $save_offer_operation->offer_deal_mode	= $operation_form['operaion_dealmode'];
                                $save_offer_operation->offer_time	= ($operation_form['operaion_till']);
                                $save_offer_operation->offer_time_type	= ucfirst($operation_form['operaion_day_hour']);
                                $save_offer_operation->offer_amount	= $operation_form['operaion_offer_amount'];
                                $save_offer_operation->offer_mipo_plus	= $operation_form['operaion_mipo_plus'];
                                $save_offer_operation->save();

                                // OperationsLogs::operationsAddLogs($operation_id, 4, '0', 'Seller', $offer_id);

                                OperationsLogs::operationsAddLogs($operation_id, 1, '0', 'Buyer', $offer_id);
                                
                            }
                        }
                    }
                }

                if($offer_type == 'Single'){
                    $save_offer_operation = new OfferOperation();
                    $save_offer_operation->offer_id	 = $offer_id;
                    $save_offer_operation->operation_id	= $operation_ids;
                    $save_offer_operation->offer_retention	= $retention;
                    $save_offer_operation->offer_deal_mode	= $preferred_payment_method;
                    $save_offer_operation->offer_time = $expires_at;
                    $save_offer_operation->offer_time_type = ucfirst($offer_day_hour);
                    $save_offer_operation->offer_amount	= $offer_amount;
                    $save_offer_operation->offer_mipo_plus	= $calc_res['is_mipo_plus'];
                    $save_offer_operation->save();

                    // OperationsLogs::operationsAddLogs($operation_ids, 4, '0', 'Seller', $offer_id);

                    OperationsLogs::operationsAddLogs($operation_ids, 1, '0', 'Buyer', $offer_id);
                }

                try {
                    $notifications_operation = config('constants.NOTIFICATIONS_TYPES.OFFERS');
                    if($offer_id > 0) {
                        if($offer_type == 'Single' && $notifications_operation['Received']) {

                            $operation = app('operation')->getOperationByIdWithSeller($operation_id);

                            Notification::send($operation->seller, new NotificationsOfferReceived($operation->operation_number));
                            
                        } else if($offer_type == 'Group' && $notifications_operation['Received']) {
                                
                            $operation = app('operation')->getOperationByIdsWithSeller($operation_ids);
                           
                            Notification::send($operation->first()->seller, new NotificationsOfferReceived($operation->pluck('operation_number')->implode(',')));

                        }
                    }
                } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                        'data' => []
                    ];
                    
                    return response()->json($response);
                }

                $response = [
                    'status' => true,
                    'message' => __('Offer added successfully'),
                    'data' => []
                ];
           
            DB::commit();
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
