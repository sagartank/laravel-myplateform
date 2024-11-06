<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Operation;
use App\Models\Offer;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __invoke()
    {
        $param = array();
        $today_date = date('Y-m-d');
        
        $data['user_id'] =  Auth()->user()->id;

        $data['type_of_documents'] = config('constants.TYPE_OF_DOCUMENT');
        $data['currency_type'] = config('constants.CURRENCY_TYPE');
        $data['currency_symbols'] = config('constants.CURRENCY_SYMBOLS');
        $data['duration_months'] = config('constants.DURATION_MONTHS');

        return view('admin.dashboard', $data);
    }

    public function ajaxDashboard__(Request $request)
    {  
        if($request->ajax())
        {
            try {
                    $param = array();
                    $today_date = date('Y-m-d');
                    
                    $data['user_id'] =  Auth()->user()->id;
                    $data['type_of_documents'] = config('constants.TYPE_OF_DOCUMENT');
                    $data['currency_type'] = config('constants.CURRENCY_TYPE');
                    $data['currency_symbols'] = config('constants.CURRENCY_SYMBOLS');
                    $data['duration_months'] = config('constants.DURATION_MONTHS');

                    if($request->has('duration_date_range')) {
                        $arr_duration_date_range = explode('-', $request->get('duration_date_range'));
                        $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
                        $param['start_date'] = $response_date['start_date'];
                        $param['end_date'] = $response_date['end_date'];
                        $param['last_month_start'] =  Carbon::createFromFormat('Y-m-d',  $param['start_date'])->subMonth()->format('Y-m-01');
                        $param['last_month_end'] = Carbon::createFromFormat('Y-m-d',  $param['last_month_start'])->format('Y-m-31');
                        $param['duration_date_range'] = $param['start_date'].'&'.$param['end_date'];
                    }

                    $param['currency_type'] = $request->get('currency_type');
                    $param['document_type'] = $request->get('document_type');
            
                    $total_user = User::select('id', 'name', 'is_active', 'is_registered', 'is_admin', 'registered_at')->where('is_admin', '!=', '1')->get();

                    $today_register_user = User::where('is_admin', '!=', '1')
                        ->whereDate('registered_at', '>=', $param['start_date'])->whereDate('registered_at', '<=', $param['end_date'])->count();

                    $today_documents_uploaded = Operation::whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])->count();
                    
                    $documents_sold = Operation::select(DB::raw('count(*) total_documents_sold'), DB::raw('sum(amount) total_documents_sold_amount'))
                        ->where('operations_status', 'Approved')->where('preferred_currency', $param['currency_type'])
                        ->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
                        ->first();
                
                    $documents_sold_type = Operation::select(DB::raw('count(*) total_documents_sold'), DB::raw('sum(amount) total_documents_sold_amount'))
                        ->where('operations_status', 'Approved')->where('preferred_currency', $param['currency_type'])->where('operation_type',  $param['document_type'])
                        ->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
                        ->first();

                    $documents_pending = Operation::where('operations_status', '!=', 'Approved')->count();

                    $total_offer = Offer::select('id', 'offer_status', 'expires_at', 'is_disputed', 'is_cashed_buyer', 'is_cashed_seller')
                        ->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
                        ->get();

                    $avg_documents_values_by_type = Operation::select(DB::raw('count(*) as total_documents_sold'), DB::raw('avg(amount) as avg_documents_values'))
                        ->where('operations_status', 'Approved')->where('preferred_currency', $param['currency_type'])->where('operation_type',  $param['document_type'])
                        ->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
                        ->whereHas('offers', function($qry){
                            $qry->whereIn('offer_status', ['Approved', 'Completed']);
                            // ->where('is_disputed', 'No');
                        })
                        ->first();

                    $deals_data_approve_completed = Operation::with('offers')
                        ->where('operations_status', 'Approved')
                        ->whereHas('offers', function($qry) {
                            $qry->whereIn('offer_status', ['Approved', 'Completed']);
                            // ->where('is_disputed', 'No');
                        })
                        ->get();

                    $avg_deals_commission_mipo = $deals_data_approve_completed->pluck('offers')->flatten()->avg('mipo_commission');

                    $avg_deals_retention = $deals_data_approve_completed->pluck('offers')->flatten()->avg('retention');

                    $deals_doc_expired_pending_cash = Offer::where('is_cashed_buyer', 'No')->where('offer_status', 'Approved')->whereDate('expires_at', '>=', $today_date)->count();
                
                    $data['total_user'] = $total_user;
                    $data['today_register_user'] = $today_register_user;
                
                    $data['today_documents_uploaded'] = $today_register_user;
                    $data['documents_sold'] = $documents_sold;
                    $data['documents_sold_type'] = $documents_sold_type;
                    $data['documents_pending'] = $documents_pending;

                    $data['total_offer'] = $total_offer;
                    $data['avg_documents_values_by_type'] = $avg_documents_values_by_type;
                    $data['avg_deals_commission_mipo'] = $avg_deals_commission_mipo;
                    $data['avg_deals_retention'] = $avg_deals_retention;
                    $data['deals_doc_expired_pending_cash'] = $avg_deals_retention;
                    $data['currency_type'] =  $param['currency_type'];

                    $dhtml = view('admin.ajax.ajax-dashboard', $data)->render();

                    $response = [
                        'status' => true,
                        'message' => '',
                        'data' => ['dhtml' => $dhtml]
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

    public function userGraphIndex() {
        return view('admin.graph.relation-graph');
    }

    public function userDataAjaxSearch(Request $request) {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = User::select("id","name")
            		->where('name','LIKE',"%$search%")
            		->get();
        }
        return response()->json($data);
    }

    public function userRelationChartData(Request $request) {
        $userIds = $request->users;
        $nodesDataArr = [];
        $linksDataArr = [];
        $groupRelationUsers = [];
        $selectedUsers = [];
        $userOfferOperations = [];
        $grouped = [];
        if(isset($userIds) && count($userIds) > 0){
            $selectedUsers = User::select("id","name")
                        ->whereIn('id',$userIds)
                        ->get();
            
            config(['database.connections.mysql.strict' => false]);
                    DB::reconnect();
            $relationUsers = Operation::select(DB::raw("GROUP_CONCAT(operations.operation_number) as deals"),"operations.seller_id","offers.buyer_id","users.name AS buyer","seller.name AS seller")
                        ->join('offer_operations', 'operations.id', '=', 'offer_operations.operation_id')
                        ->join('offers', 'offer_operations.offer_id', '=', 'offers.id')
                        ->join('users', 'offers.buyer_id', '=', 'users.id')
                        ->join('users AS seller', 'operations.seller_id', '=', 'seller.id')
                        //->whereIn('operations.seller_id', $userIds)
                        ->where(function($query) use($userIds)
                        {
                            $query->whereIn('operations.seller_id', $userIds)
                            ->orWhereIn('offers.buyer_id', $userIds);
                        })
                        ->where('offers.offer_status', 'Approved')
                        ->groupBy('operations.seller_id','offers.buyer_id')
                        ->get();
            config(['database.connections.mysql.strict' => true]);
            DB::reconnect();

            $groupRelationUsers = $relationUsers->groupBy('seller')->all();

            $sellerArray = $relationUsers->pluck('seller')->toArray();
            $buyerArray = $relationUsers->pluck('buyer')->toArray();

            $nodesArray = array_unique(array_merge($sellerArray, $buyerArray));
            
            foreach($nodesArray as $key=>$val){
                $nodesDataArr[] = [
                    "id" => $val,
                    "name" => $val
                ];
            }
            foreach($relationUsers as $key=>$relation){
                $linksDataArr[] = [
                    "source" => $relation->seller,
                    "target" => $relation->buyer
                ];
            }
            /**
             * For connectivity users
             */
            $userOfferOperations = Operation::select("operations.slug AS operation_slug","operations.operation_number","operations.seller_id","offers.buyer_id","users.name AS buyer","seller.name AS seller","operations.preferred_currency","operations.created_at AS date_time","operations.amount","operations.operation_type")
                        ->join('offer_operations', 'operations.id', '=', 'offer_operations.operation_id')
                        ->join('offers', 'offer_operations.offer_id', '=', 'offers.id')
                        ->join('users', 'offers.buyer_id', '=', 'users.id')
                        ->join('users AS seller', 'operations.seller_id', '=', 'seller.id')
                        //->whereIn('operations.seller_id', $userIds)
                        ->where(function($query) use($userIds)
                        {
                            $query->whereIn('operations.seller_id', $userIds)
                            ->orWhereIn('offers.buyer_id', $userIds);
                        })
                        ->where('offers.offer_status', 'Approved')
                        ->get();

                        $grouped = $userOfferOperations->groupBy('seller'); 
                        
            $dataSeller = [];
            foreach($grouped as $key=>$row){
                foreach($row->groupBy('preferred_currency') as $currencyKey => $currency_group){
                    foreach($currency_group as $ckey => $currency){
                        $dataSeller[$key][$currencyKey][] = [
                            'relation' => $key .' - '.$currency->buyer,
                            'amount' => $currency->amount,
                        ];
                    }
                }
            }          
            
        }

        return view('admin.graph.relation-graph',compact('groupRelationUsers','nodesDataArr','linksDataArr','selectedUsers','userOfferOperations','grouped'));
    }

    public function getUserConnectivityChartData(Request $request)
    {
        if($request->ajax())
        {
            try {
                $userIds = $request->users;
                config(['database.connections.mysql.strict' => false]);
                        DB::reconnect();
                $relationUsers = Operation::select(DB::raw("GROUP_CONCAT(operations.operation_number) as deals"),"operations.seller_id","offers.buyer_id","users.name AS buyer","seller.name AS seller")
                            ->join('offer_operations', 'operations.id', '=', 'offer_operations.operation_id')
                            ->join('offers', 'offer_operations.offer_id', '=', 'offers.id')
                            ->join('users', 'offers.buyer_id', '=', 'users.id')
                            ->join('users AS seller', 'operations.seller_id', '=', 'seller.id')
                           // ->whereIn('operations.seller_id', $userIds)
                            ->where(function($query) use($userIds)
                            {
                                $query->whereIn('operations.seller_id', $userIds)
                                ->orWhereIn('offers.buyer_id', $userIds);
                            })
                            ->where('offers.offer_status', 'Approved')
                            ->groupBy('operations.seller_id','offers.buyer_id')
                            ->get();
                config(['database.connections.mysql.strict' => true]);
                DB::reconnect();
                
                $groupRelationUsers = $relationUsers->groupBy('seller')->all();

                $sellerArray = $relationUsers->pluck('seller')->toArray();
                $buyerArray = $relationUsers->pluck('buyer')->toArray();

                $nodesArray = array_unique(array_merge($sellerArray, $buyerArray));
                $nodesDataArr = [];
                $linksDataArr = [];
                foreach($nodesArray as $key=>$val){
                    $nodesDataArr[] = [
                        "id" => $val,
                        "name" => $val
                    ];
                }
                foreach($relationUsers as $key=>$relation){
                    $linksDataArr[] = [
                        "source" => $relation->seller,
                        "target" => $relation->buyer
                    ];
                }
                $connectionUsersView = view('admin.graph.ajax-relation-users-connections',compact('groupRelationUsers'))->render();
                $connectionUsersGraphView = '';//view('admin.graph.ajax-relation-users-connections-graph',compact('nodesDataArr','linksDataArr'))->render();
                
                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => [
                        'userHtml' => $connectionUsersView,
                        'dhtml'=>$connectionUsersGraphView,
                        'nodesDataArr'=>json_encode($nodesDataArr),
                        'linksDataArr'=>json_encode($linksDataArr)
                    ]
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

    public function notificaitonList(Request $request) {
        $param = array();
        
        $today_date = date('Y-m-d');
        
        $data['user_id'] =  Auth()->user()->id;
        $notifications = Auth()->user()->unreadNotifications;

        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');

        $data['notifications'] = $notifications;
        $data['is_send_admin_notification'] = $is_send_admin_notification;

        return view('admin.notifications', $data);
    }

    public function ajaxDashboard(Request $request) {
        $param = array();
        $today_date = date('Y-m-d');
        
        $data['user_id'] =  Auth()->user()->id;
        $data['type_of_documents'] = config('constants.TYPE_OF_DOCUMENT');
        $data['currency_type'] = config('constants.CURRENCY_TYPE');
        $data['currency_symbols'] = config('constants.CURRENCY_SYMBOLS');
        $data['duration_months'] = config('constants.DURATION_MONTHS');

        if($request->has('duration_date_range')) {
            $arr_duration_date_range = explode('-', $request->get('duration_date_range'));
            $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
            $param['start_date'] = $response_date['start_date'];
            $param['end_date'] = $response_date['end_date'];
            $param['last_month_start'] =  Carbon::createFromFormat('Y-m-d',  $param['start_date'])->subMonth()->format('Y-m-01');
            $param['last_month_end'] = Carbon::createFromFormat('Y-m-d',  $param['last_month_start'])->format('Y-m-31');
            $param['duration_date_range'] = $param['start_date'].'&'.$param['end_date'];
        }

        $param['currency_type'] = $request->get('currency_type');
        $param['document_type'] = $request->get('document_type');
        
        $totalNewUser = User::where('is_admin', '0')->where('is_registered', '1')
            ->whereDate('registered_at', '>=', $param['start_date'])->whereDate('registered_at', '<=', $param['end_date'])->count();
        
        $totalOnlineUser = User::where('is_admin', '0')->where('is_active',  '1')->where('is_registered', '1')
            ->whereDate('registered_at', '>=', $param['start_date'])->whereDate('registered_at', '<=', $param['end_date'])->count();

        $totalLoadedOperations = Operation::whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
                                ->where('operation_type',  $param['document_type'])->count();

        $totalSentOffer = Offer::whereIn('offer_status', ['Pending'])->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
            ->whereHas('operations', function($qry) use ($param){
                $qry->where('is_offered', '0')->where('operation_type',  $param['document_type']);
            })
            ->count();

        $totalCounterSentOffer = Offer::whereIn('offer_status', ['Counter'])->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
        ->whereHas('operations', function($qry) use ($param){
            $qry->where('is_offered', '0')->where('operation_type',  $param['document_type']);
        })
            ->count();
        
        $totalCompletedOperations = Operation::select('id', 'amount', 'preferred_currency', 'operation_type', 'amount_requested')->whereIn('operations_status', ['Approved'])
            ->whereDate('expiration_date_document', '>=', $param['start_date'])->whereDate('expiration_date_document', '<=', $param['end_date'])
            ->where('operation_type',  $param['document_type'])
            ->get();

        $totalGsOpAmount = $totalCompletedOperations->where('preferred_currency', '!=', 'USD')->pluck('amount')->sum();
        $totalUsdOpAmount = $totalCompletedOperations->where('preferred_currency', 'USD')->pluck('amount')->sum();

        $commissionsGenerated = 0;
        $byOperations  = 0;
        $mipoPlus  = 0;

        $now = Carbon::now();
        $oneWeekFromNow = $now->copy()->addWeek();
        $oneMonthFromNow = $now->copy()->addMonth();
        $oneWeekAgo = Carbon::now()->subWeek();
        $oneMonthAgo = Carbon::now()->subMonth();

        $documentsDueToday = Operation::whereDate('expiration_date_document', '>=', $param['start_date'])->whereDate('expiration_date_document', '<', $param['end_date'])
            ->where('operation_type',  $param['document_type'])->count();
        
        $documentsExpiringInOneWeek             = Operation::whereBetween('expiration_date_document', [$param['start_date'], $oneWeekFromNow])->where('operation_type',  $param['document_type'])->count();
        $documentsExpiringInOneMonth            = Operation::whereBetween('expiration_date_document', [$param['start_date'], $oneMonthFromNow])->where('operation_type',  $param['document_type'])->count();
        $expiredDocumentsOneWeekAgo             = Operation::whereDate('expiration_date_document', '<', $oneWeekAgo)->where('operation_type',  $param['document_type'])->count(); 
        $expiredDocumentsOneMonthAgo            = Operation::whereDate('expiration_date_document', '<', $oneWeekAgo)->where('operation_type',  $param['document_type'])->count();

        $expiredTransactionsMoreThanOneMonthAgo = Offer::where('offer_status', 'Approved')->whereDate('expires_at', '<', $oneMonthAgo)->where('is_mipo_commission_payment', 'No')
                                                    ->whereHas('operations', function($qry) use ($param){
                                                        $qry->where('is_offered', '1')->where('operation_type',  $param['document_type']);
                                                    })->count();
    
        $totalOpenDisputes                      = Offer::where('is_disputed', 'Yes')->where('offer_status', 'Approved')
                                                    ->whereHas('operations', function($qry) use ($param){
                                                        $qry->where('is_offered', '1')->where('operation_type',  $param['document_type']);
                                                    })->count();

        $totalCloseDisputes                     = Offer::where('is_disputed', 'No')->where('offer_status', 'Approved')
                                                ->whereHas('operations', function($qry) use ($param){
                                                    $qry->where('is_offered', '1')->where('operation_type',  $param['document_type']);
                                                })->count();
                                                
        $data['totalNewUser'] = $totalNewUser;
        $data['totalOnlineUser'] = $totalOnlineUser;
        $data['totalLoadedOperations'] = $totalLoadedOperations;
        $data['totalSentOffer'] = $totalSentOffer;
        $data['totalCounterSentOffer'] = $totalCounterSentOffer;
        $data['totalCompletedOperations'] = $totalCompletedOperations->count();
        $data['totalUsdOpAmount'] = app('common')->currencyNumberFormat($data['currency_type'][0], $totalUsdOpAmount);;
        $data['totalGsOpAmount'] = app('common')->currencyNumberFormat($data['currency_type'][1], $totalGsOpAmount);
        $data['commissionsGenerated'] = $commissionsGenerated;
        $data['byOperations'] = $byOperations;
        $data['mipoPlus'] = $mipoPlus;

        $data['documentsDueToday'] = $documentsDueToday;
        $data['documentsExpiringInOneWeek'] = $documentsExpiringInOneWeek;
        $data['documentsExpiringInOneMonth'] = $documentsExpiringInOneMonth;
        $data['expiredDocumentsOneWeekAgo'] = $expiredDocumentsOneWeekAgo; 
        $data['expiredDocumentsOneMonthAgo'] = $expiredDocumentsOneMonthAgo;
        $data['expiredTransactionsMoreThanOneMonthAgo'] = $expiredTransactionsMoreThanOneMonthAgo;
        $data['totalOpenDisputes'] = $totalOpenDisputes;
        $data['totalCloseDisputes'] = $totalCloseDisputes;

        $dhtml = view('admin.ajax.ajax-dashboard', $data)->render();

        $response = [
            'status' => true,
            'message' => '',
            'data' => ['dhtml' => $dhtml]
        ];

        return response()->json($response);
    }

    public function ExportDailyReport(Request $request)
    {
        $param = array();
        $today_date = date('Y-m-d');
        
        $data['user_id'] =  Auth()->user()->id;
        $data['type_of_documents'] = config('constants.TYPE_OF_DOCUMENT');
        $data['currency_type'] = config('constants.CURRENCY_TYPE');
        $data['currency_symbols'] = config('constants.CURRENCY_SYMBOLS');
        $data['duration_months'] = config('constants.DURATION_MONTHS');

        if($request->has('duration_date_range')) {
            $arr_duration_date_range = explode('-', $request->get('duration_date_range'));
            $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
            $param['start_date'] = $response_date['start_date'];
            $param['end_date'] = $response_date['end_date'];
            $param['last_month_start'] =  Carbon::createFromFormat('Y-m-d',  $param['start_date'])->subMonth()->format('Y-m-01');
            $param['last_month_end'] = Carbon::createFromFormat('Y-m-d',  $param['last_month_start'])->format('Y-m-31');
            $param['duration_date_range'] = $param['start_date'].'&'.$param['end_date'];
        }

        $fileName = 'daily_report_'.time().'.pdf';

        
        $total_user = User::select('id', 'name', 'is_active', 'is_registered', 'is_admin', 'registered_at')->where('is_admin', '!=', '1')->get();

        $today_register_user = User::where('is_admin', '!=', '1')
            ->whereDate('registered_at', '>=', $param['start_date'])->whereDate('registered_at', '<=', $param['end_date'])->count();
        
        $totalNewUser = User::where('is_admin', '0')->where('is_registered', '1')
            ->whereDate('registered_at', '>=', $param['start_date'])->whereDate('registered_at', '<=', $param['end_date'])->count();
        
        $totalOnlineUser = User::where('is_admin', '0')->where('is_active',  '1')->where('is_registered', '1')
            ->whereDate('registered_at', '>=', $param['start_date'])->whereDate('registered_at', '<=', $param['end_date'])->count();

        $totalLoadedOperations = Operation::whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])->count();

        $totalSentOffer = Offer::whereIn('offer_status', ['Pending'])->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
            ->whereHas('operations', function($qry){
                $qry->where('is_offered', '0');
            })
            ->count();

        $totalCounterSentOffer = Offer::whereIn('offer_status', ['Counter'])->whereDate('created_at', '>=', $param['start_date'])->whereDate('created_at', '<=', $param['end_date'])
            ->whereHas('operations', function($qry){
                $qry->where('is_offered', '0');
            })
            ->count();
        
        $totalCompletedOperations = Operation::select('id', 'amount', 'preferred_currency', 'operation_type', 'amount_requested')->whereIn('operations_status', ['Approved'])
            ->whereDate('expiration_date_document', '>=', $param['start_date'])->whereDate('expiration_date_document', '<=', $param['end_date'])
            ->get();

        $totalGsOpAmount = $totalCompletedOperations->where('preferred_currency', '!=', 'USD')->pluck('amount')->sum();
        $totalUsdOpAmount = $totalCompletedOperations->where('preferred_currency', 'USD')->pluck('amount')->sum();

        $commissionsGenerated = 0;
        $byOperations  = 0;
        $mipoPlus  = 0;

        $now = Carbon::now();
        $oneWeekFromNow = $now->copy()->addWeek();
        $oneMonthFromNow = $now->copy()->addMonth();
        $oneWeekAgo = Carbon::now()->subWeek();
        $oneMonthAgo = Carbon::now()->subMonth();

        $documentsDueToday = Operation::whereDate('expiration_date_document', '>=', $param['start_date'])->whereDate('expiration_date_document', '<', $param['end_date'])->count();
      
        $documentsExpiringInOneWeek             = Operation::whereBetween('expiration_date_document', [$param['start_date'], $oneWeekFromNow])->count();
        $documentsExpiringInOneMonth            = Operation::whereBetween('expiration_date_document', [$param['start_date'], $oneMonthFromNow])->count();
        $expiredDocumentsOneWeekAgo             = Operation::whereDate('expiration_date_document', '<', $oneWeekAgo)->count(); 
        $expiredDocumentsOneMonthAgo            = Operation::whereDate('expiration_date_document', '<', $oneWeekAgo)->count();
        $expiredTransactionsMoreThanOneMonthAgo = Offer::where('offer_status', 'Approved')->whereDate('expires_at', '<', $oneMonthAgo)->where('is_mipo_commission_payment', 'No')->count();
    
        $totalOpenDisputes                      = Offer::where('is_disputed', 'Yes')->where('offer_status', 'Approved')->count();
        $totalCloseDisputes                     = Offer::where('is_disputed', 'No')->where('offer_status', 'Approved')->count(); 

        $data['totalNewUser'] = $totalNewUser;
        $data['totalOnlineUser'] = $totalOnlineUser;
        $data['totalLoadedOperations'] = $totalLoadedOperations;
        $data['totalSentOffer'] = $totalSentOffer;
        $data['totalCounterSentOffer'] = $totalCounterSentOffer;
        $data['totalCompletedOperations'] = $totalCompletedOperations->count();
        $data['totalUsdOpAmount'] = app('common')->currencyNumberFormat($data['currency_type'][0], $totalUsdOpAmount);;
        $data['totalGsOpAmount'] = app('common')->currencyNumberFormat($data['currency_type'][1], $totalGsOpAmount);
        $data['commissionsGenerated'] = $commissionsGenerated;
        $data['byOperations'] = $byOperations;
        $data['mipoPlus'] = $mipoPlus;

        $data['documentsDueToday'] = $documentsDueToday;
        $data['documentsExpiringInOneWeek'] = $documentsExpiringInOneWeek;
        $data['documentsExpiringInOneMonth'] = $documentsExpiringInOneMonth;
        $data['expiredDocumentsOneWeekAgo'] = $expiredDocumentsOneWeekAgo; 
        $data['expiredDocumentsOneMonthAgo'] = $expiredDocumentsOneMonthAgo;
        $data['expiredTransactionsMoreThanOneMonthAgo'] = $expiredTransactionsMoreThanOneMonthAgo;
        $data['totalOpenDisputes'] = $totalOpenDisputes;
        $data['totalCloseDisputes'] = $totalCloseDisputes;
        

        $pdf = Pdf::loadView('admin.dashboard-daily-report-pdf', $data);

        $filePath = "/admin/pdf/";

        $fileFullPath = storage_path('app'.$filePath.$fileName);
        
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        $content = $pdf->download()->getOriginalContent();

        $is_storage = Storage::put($filePath.$fileName, $content);
      
        $file_downalod = route('secure-pdf', Crypt::encryptString($filePath.$fileName));
      
        if($is_storage && $file_downalod)
        {
            $response = [
                'status' => true,
                'message' => '',
                'file_downalod' =>  $file_downalod,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => __('Something went wrong please try again!'),
                'file_downalod' => null ,
            ];
        }
        return response()->json($response);
    }
}
