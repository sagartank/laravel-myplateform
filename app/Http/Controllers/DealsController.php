<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Operation;
use App\Models\OperationProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DealsDocuments;
use App\Models\DealsDisputes;
use App\Models\DealsPrivateNote;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OnceCashedInvestor as NotificationOnceCashedInvestor;
use App\Notifications\DealDisputesCreated as NotificationAdminDealDisputesCreated;
use App\Models\OperationsLogs;
use App\Models\User;
use App\Models\BankDetails;
use Deviam\Bancard\Bancard;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\OfferOperation;
use App\Models\Rating;
use App\Models\Issuer;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentCollectionAndReviewByBuyer;

class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_type ='seller', $currency_type = '')
    {
        if(empty($user_type) || !in_array($user_type, ['seller', 'buyer'])) {
            abort(404, 'Page not found!');
        }
        
        $param['user_id'] =  Auth()->user()->id;

        $deals_dashboard_seller = app('dashboard')->dealsSeller($param);

        $deals_dashboard_buyer = app('dashboard')->dealsBuyer($param);
    
        $data['deals_dashboard_seller'] = $deals_dashboard_seller;
        $data['deals_dashboard_buyer'] = $deals_dashboard_buyer;
        $data['user_type'] = $user_type;
        $data['currency_type'] = $currency_type;

        return view('deals.index', $data);
    }

    public function ajaxDealsListBuyer(Request $request)
    {
        if($request->ajax())
        {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');
                $page = $request->input('page');
                $param = $request->all();
                $sort_type = $request->get('sort_type', 'ASC');
                $column_name = 'id';
                if($sort_type == 'amount_asc'){
                    $column_name = 'amount';
                    $sort_type = 'ASC';
                }
                if($sort_type == 'amount_desc') {
                    $column_name = 'amount';
                    $sort_type = 'DESC';
                }

                $deals = $this->dealsDataBuyerSeller($param, 'buyer', $per_page, $sort_type, $column_name);

                $deals_dashboard_buyer = $this->dealsDataBuyerSellerDeshboard($param, 'buyer', $sort_type, $column_name);

                $buyer_steps = OperationProgress::buyerSteps()->pluck('title_es', 'title_en',)->toArray();
            
                $dhtml = view('deals.ajax.ajax-deals-list-buyer', ['deals_record' => $deals, 'currency_symblos' => $currency_symblos,
                'current_page' => $deals->currentPage(), 'last_page' => $deals->lastPage(), 'has_more_pages' => $deals->hasMorePages(),
                'buyer_steps' => $buyer_steps
                ])->render();

                $dhtml_deals_buyer_dashboard = '';
                if($request->get('deals_filter_dashboard') == true) {
                    $dhtml_deals_buyer_dashboard= view('deals.ajax.ajax-deals-buyer-dashboard',['deals_dashboard_buyer' => $deals_dashboard_buyer])->render();
                }
                $response = [
                    'status' => true,
                    'message' => __('Deal list'),
                    'data' => ['dhtml' => $dhtml, 'deals_buyer_dashboard' => $dhtml_deals_buyer_dashboard, 'next_page_url' => $deals->nextPageUrl()]
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

    public function ajaxDealsListSeller(Request $request)
    {
        if($request->ajax())
        {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');
                $page = $request->input('page');
                $param = $request->all();
                $sort_type = $request->get('sort_type', 'ASC');
                $column_name = 'id';
                if($sort_type == 'amount_asc'){
                    $column_name = 'amount';
                    $sort_type = 'ASC';
                }
                if($sort_type == 'amount_desc') {
                    $column_name = 'amount';
                    $sort_type = 'DESC';
                }
                
                $deals_dashboard_buyer = app('dashboard')->dealsBuyer($param);

                $deals = $this->dealsDataBuyerSeller($param, 'seller', $per_page, $sort_type, $column_name);

                $deals_dashboard_seller = $this->dealsDataBuyerSellerDeshboard($param, 'seller', $sort_type, $column_name);

                $seller_steps = OperationProgress::SellerSteps()->pluck('title_es', 'title_en',)->toArray();

                /* foreach($deals_dashboard_seller as $deals) {
                    dd($deals->offers_logs->first()->title);
                } */

                $dhtml = view('deals.ajax.ajax-deals-list-seller', [
                    'deals_record' => $deals, 'currency_symblos' => $currency_symblos,
                    'current_page' => $deals->currentPage(), 'last_page' => $deals->lastPage(), 'has_more_pages' => $deals->hasMorePages(),
                    'seller_steps' => $seller_steps
                    ])->render();
                
                $dhtml_deals_seller_dashboard = '';
                if($request->get('deals_filter_dashboard') == true) {
                    $dhtml_deals_seller_dashboard = view('deals.ajax.ajax-deals-seller-dashboard',['deals_dashboard_seller' => $deals_dashboard_seller ])->render();
                }
                $response = [
                    'status' => true,
                    'message' => __('Deal list'),
                    'data' => ['dhtml' => $dhtml, 'deals_seller_dashboard' => $dhtml_deals_seller_dashboard]
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
    
    public function dealsDataBuyerSeller($param, $user_type, $per_page, $sort_type, $column_name)
    {
        return Offer::has('operations')->with([
            'buyer',
            'buyer.city:id,name',
            'offers_logs' => function($qry) use ($user_type) {
                $log_type = 'All';
                if($user_type == 'buyer') {
                    $log_type = 'Buyer';
                } else if($user_type == 'seller') {
                    $log_type = 'Seller';
                }
                $qry->select('id','operation_id', 'offer_id', 'title', 'is_completed', 'is_current', 'log_types')->where('log_types', $log_type);
            },
            'operations' => function($qry){
                    $qry->select('*')->with([
                        'seller',
                        'seller.city:id,name',
                        'issuer',
                        'documents',
                        'supportingAttachments',
                    ]);
                } 
            ])
            ->when($user_type, function($query) use ($user_type) {
                if($user_type == 'buyer') {
                    $query->where('buyer_id', '=',  Auth()->user()->id);
                }
                if($user_type == 'seller') {
                    $query->where('buyer_id', '!=',  Auth()->user()->id);
                    $query->whereHas('operations' , function($qry){
                        $qry->where('seller_id', Auth()->user()->id);
                    });
                }
            })->when(isset($param['issuer_ids']), function($query) use ($param) {
                if(isset($param['issuer_ids']) && !empty($param['issuer_ids'])) {
                    $query->whereHas('operations', function($qry) use ($param) {
                            $qry->whereIn('issuer_id', $param['issuer_ids']);
                    });
                }
            })
            ->when(isset($param), function($query) use ($param) {
                if(isset($param['preferred_currency']) || isset($param['operation_type']) || isset($param['preferred_payment_method']))
                {
                    $query->whereHas('operations', function($qry) use ($param) {
                        if(isset($param['preferred_currency']) && count($param['preferred_currency']) > 0) {
                            $qry->whereIn('preferred_currency', $param['preferred_currency']);
                        }
                        if(isset($param['operation_type']) && count($param['operation_type']) > 0) {
                            $qry->whereIn('operation_type', $param['operation_type']);
                        }
                        if(isset($param['preferred_payment_method']) && count($param['preferred_payment_method']) > 0) {
                            $qry->whereIn('preferred_payment_method', $param['preferred_payment_method']);
                        }
                    });
                }
            })->when(true, function($query) use ($param) {
                if(isset($param['deals_status']) && !empty($param['deals_status'])){
                        if(in_array(trim($param['deals_status']), ['Approved', 'Completed'])) {
                            $query->where('offer_status', $param['deals_status']);
                        } else if($param['deals_status'] == 'Rejected') {
                            $query->where('is_disputed', 'Yes')->whereIn('offer_status', ['Approved']);
                        } else if($param['deals_status'] == 'mipo_deals') {
                            $query->where('is_mipo_plus', 'Yes')->whereIn('offer_status', ['Approved', 'Completed']);
                        }
                } else {
                    $query->whereIn('offer_status', ['Approved', 'Completed']);
                }
            })
            ->when(isset($param['is_chk_usd']), function($query) use ($param) {
                if(isset($param['is_chk_usd'])){
                    $usd = config('constants.CURRENCY_TYPE')[0];
                    $query->whereHas('operations', function($qry) use ($param, $usd) {
                        if(isset($param['min_usd']) && isset($param['max_usd'])){
                            $qry->where(function($qry) use ($param, $usd){
                                $qry->where('amount', '>=', $param['min_usd'])
                                ->where('amount', '<=', $param['max_usd'])
                                ->where('preferred_currency', $usd);
                            });
                        } else if(isset($param['max_usd'])) {
                            $qry->where('amount', '<=', $param['max_usd'])->where('preferred_currency', $usd);
                        } else if(isset($param['min_usd'])) {
                            $qry->where('amount', '>=', $param['min_usd'])->where('preferred_currency', $usd);
                        } else {
                            $qry->where('preferred_currency', $usd);
                        }
                    });
                }
            })
            ->when(isset($param['is_chk_gs']), function($query) use ($param) {
                if(isset($param['is_chk_gs'])){
                    $gs = config('constants.CURRENCY_TYPE')[1];
                    $query->whereHas('operations', function($qry) use ($param,$gs) {
                        if(isset($param['min_gs']) && isset($param['max_gs'])){
                            $qry->where(function($qry) use ($param, $gs){
                                $qry->where('amount', '>=', $param['min_gs'])
                                ->where('amount', '<=', $param['max_usd'])
                                ->where('preferred_currency', $gs);
                            });
                        } else if(isset($param['max_gs'])) {
                            $qry->where('amount', '<=', $param['max_gs'])->where('preferred_currency', $gs);
                        } else if(isset($param['min_gs'])) {
                            $qry->where('amount', '>=', $param['min_gs'])->where('preferred_currency', $gs);
                        } else {
                            $qry->where('preferred_currency', $gs);
                        }
                    });
                }
            })
            ->when($param, function($query) use ($param){
                if(isset($param['duration_date_range']) && !empty($param['duration_date_range'])) {
                    $response_date = app('common')->dateRangeExplode($param['duration_date_range'], '-');
                    $param_date['start_date'] = $response_date['start_date'] ?? null;
                    $param_date['end_date'] = $response_date['end_date'] ?? null;
                    if($param_date['start_date'] && $param_date['end_date']) {
                        $query->where(function($qry) use ($param_date){
                            $qry->whereDate('expires_at', '>=', $param_date['start_date']);
                        });
                    }
                }
            })
            ->when($column_name, function($query) use ($sort_type, $column_name){
                if($column_name == 'amount'){
                    $query->orderByRaw('CONVERT(amount, SIGNED) '. $sort_type);
                } else {
                    $query->orderBy($column_name, $sort_type);
                }
            })
            // ->where('is_seller_deals_contract', 'Yes')->where('is_buyer_deals_contract', 'Yes')
            ->paginate($per_page);
    }

    public function dealsDataBuyerSellerDeshboard($param, $user_type, $sort_type, $column_name)
    {
        return Offer::has('operations')->with([
            'buyer',
            'buyer.city:id,name',
            'operations' => function($qry){
                    $qry->select('*')->with([
                        'seller',
                        'seller.city:id,name',
                        'issuer',
                        'documents',
                        'supportingAttachments',
                    ]);
                } 
            ])
            ->when($user_type, function($query) use ($user_type) {
                if($user_type == 'buyer') {
                    $query->where('buyer_id', '=',  Auth()->user()->id);
                }
                if($user_type == 'seller') {
                    $query->where('buyer_id', '!=',  Auth()->user()->id);
                    $query->whereHas('operations' , function($qry){
                        $qry->where('seller_id', Auth()->user()->id);
                    });
                }
            })->when(isset($param['issuer_ids']), function($query) use ($param) {
                if(isset($param['issuer_ids']) && !empty($param['issuer_ids'])) {
                    $query->whereHas('operations', function($qry) use ($param) {
                            $qry->whereIn('issuer_id', $param['issuer_ids']);
                    });
                }
            })
            ->when(isset($param), function($query) use ($param) {
                if(isset($param['preferred_currency']) || isset($param['operation_type']) || isset($param['preferred_payment_method']))
                {
                    $query->whereHas('operations', function($qry) use ($param) {
                        if(isset($param['preferred_currency']) && count($param['preferred_currency']) > 0) {
                            $qry->whereIn('preferred_currency', $param['preferred_currency']);
                        }
                        if(isset($param['operation_type']) && count($param['operation_type']) > 0) {
                            $qry->whereIn('operation_type', $param['operation_type']);
                        }
                        if(isset($param['preferred_payment_method']) && count($param['preferred_payment_method']) > 0) {
                            $qry->whereIn('preferred_payment_method', $param['preferred_payment_method']);
                        }
                    });
                }
            })->when(true, function($query) use ($param) {
                if(isset($param['deals_status']) && !empty($param['deals_status'])){
                        if(in_array(trim($param['deals_status']), ['Approved', 'Completed'])) {
                            $query->where('offer_status', $param['deals_status']);
                        } else if($param['deals_status'] == 'Rejected') {
                            $query->where('is_disputed', 'Yes')->whereIn('offer_status', ['Approved']);
                        } else if($param['deals_status'] == 'mipo_deals') {
                            $query->where('is_mipo_plus', 'Yes')->whereIn('offer_status', ['Approved', 'Completed']);
                        }
                } else {
                    $query->whereIn('offer_status', ['Approved', 'Completed']);
                }
            })
            ->when(isset($param['is_chk_usd']), function($query) use ($param) {
                if(isset($param['is_chk_usd'])){
                    $usd = config('constants.CURRENCY_TYPE')[0];
                    $query->whereHas('operations', function($qry) use ($param, $usd) {
                        if(isset($param['min_usd']) && isset($param['max_usd'])){
                            $qry->where(function($qry) use ($param, $usd){
                                $qry->where('amount', '>=', $param['min_usd'])
                                ->where('amount', '<=', $param['max_usd'])
                                ->where('preferred_currency', $usd);
                            });
                        } else if(isset($param['max_usd'])) {
                            $qry->where('amount', '<=', $param['max_usd'])->where('preferred_currency', $usd);
                        } else if(isset($param['min_usd'])) {
                            $qry->where('amount', '>=', $param['min_usd'])->where('preferred_currency', $usd);
                        } else {
                            $qry->where('preferred_currency', $usd);
                        }
                    });
                }
            })
            ->when(isset($param['is_chk_gs']), function($query) use ($param) {
                if(isset($param['is_chk_gs'])){
                    $gs = config('constants.CURRENCY_TYPE')[1];
                    $query->whereHas('operations', function($qry) use ($param,$gs) {
                        if(isset($param['min_gs']) && isset($param['max_gs'])){
                            $qry->where(function($qry) use ($param, $gs){
                                $qry->where('amount', '>=', $param['min_gs'])
                                ->where('amount', '<=', $param['max_usd'])
                                ->where('preferred_currency', $gs);
                            });
                        } else if(isset($param['max_gs'])) {
                            $qry->where('amount', '<=', $param['max_gs'])->where('preferred_currency', $gs);
                        } else if(isset($param['min_gs'])) {
                            $qry->where('amount', '>=', $param['min_gs'])->where('preferred_currency', $gs);
                        } else {
                            $qry->where('preferred_currency', $gs);
                        }
                    });
                }
            })
            ->when($param, function($query) use ($param){
                if(isset($param['duration_date_range']) && !empty($param['duration_date_range'])) {
                    $response_date = app('common')->dateRangeExplode($param['duration_date_range'], '-');
                    $param_date['start_date'] = $response_date['start_date'] ?? null;
                    $param_date['end_date'] = $response_date['end_date'] ?? null;
                    if($param_date['start_date'] && $param_date['end_date']) {
                        $query->where(function($qry) use ($param_date){
                            $qry->whereDate('expires_at', '>=', $param_date['start_date']);
                        });
                    }
                }
            })->get();
    }

    public function dealsDetails(Request $request, $slug, $type = 'seller')
    {
        if(empty($type) || !in_array($type, ['seller', 'buyer'])) {
            abort(404, 'Page not found!');
        }   

        $param = $request->all();
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        
        $result = Offer::with([
            'buyer',  
            'buyer.city:id,name',  
            'offers_logs',
            'deals_disputes',
            'operations' => function($qry) {
                $qry->OperationSelect();
                $qry->with([
                    'seller',
                    'seller.city:id,name',
                    'issuer',
                    'supportingAttachments',
                    'documents',
                    'operations_logs',
                    'seller' => fn($qry) => $qry->withAvg('ratings', 'rating_number')->withCount('ratings'),
                    'issuer' => fn($qry) => $qry->withAvg('ratings', 'rating_number')->withCount('ratings')
                ]);
            },
            'buyer' => fn($qry) => $qry->withAvg('ratings', 'rating_number')->withCount('ratings'),
            'deals_contract' => fn($qry) => $qry->select('id', 'offer_id', 'deals_contract_file')
            ])
            ->where('slug', $slug)
            ->whereIn('offer_status', ['Approved', 'Completed'])
            ->first();

        if(is_null($result)) {
            abort(404, 'Page not found!');
        }

        $user_login_id = Auth()->user()->id;
        if($type == 'buyer') {
            if($user_login_id != $result->buyer_id) {
                abort(404, 'Page not found!');
            }
        } else if($type == 'seller') {
            $seller_id = $result->operations->first()->seller_id;
            if($user_login_id != $seller_id) {
                abort(404, 'Page not found!');
            }
        }

        $offer_id = $result->id;
        
        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($result->id);

        $investor_commission = app('common')->userPlan()->investor_commission;
        $mipo_commission = app('common')->userPlan()->mipo_commission;

        $bank_details = [];
        if($type == 'buyer') {
            $progress = $result_deals_tracking['buyer_steps'];
            $es_logs_offers = $result_deals_tracking['buyer_steps']->pluck('title_es', 'title_en');
            $seller_id = $result->operations->first()->seller_id;
            $bank_details = BankDetails::where('user_id', $seller_id)->get();
        } else {
            $progress = $result_deals_tracking['seller_steps'];
            $es_logs_offers = $result_deals_tracking['seller_steps']->pluck('title_es', 'title_en');
        }

        $is_current = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $type)->where('is_current', '1')->count();
        
        if($is_current == 0) {
            $is_update = OperationsLogs::where('offer_id', $offer_id)->where('is_current', '0')->where('log_types', $type)->orderBy('id', 'DESC')->first();
            if($is_update) {
                $is_update->is_current = '1';
                $is_update->save();
            }
        }   
        
        $langs = (config('constants.languages.' . App()->getLocale()) == 'English') ? 'en' : 'es';
        if($result)
        {
            return view('deals.details', ['operation_detail' => $result, 'currency_symblos' => $currency_symblos, 'progress' => $progress, 'type' => ucfirst($type), 'langs' => $langs, 'es_logs_offers' => $es_logs_offers, 'bank_details' => $bank_details, 'investor_commission' => $investor_commission, 'mipo_commission' => $mipo_commission ]);
        } else {
            return redirect()->route('deals.index');
        }
    }

    public function createDisputes(Request $request, $slug)
    {
        $validated = $request->validate([
            'disputes_note' => 'required|min:5',
        ]);

        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');

        if($request->ajax() && !empty($slug))
        {
            DB::beginTransaction();
            try {
                $disputes_note = $request->disputes_note;
                $offer = Offer::where('slug', $slug)->first();
                if($offer) {
                    $offer->is_disputed = 'Yes';
                    $offer->save();
                    $offer_id = $offer->id;
                    if ($request->hasFile('disputes_file')) {
                        $disputes_file = $request->file('disputes_file');
                        $name = str_replace(' ', '_', $disputes_file->getClientOriginalName());
                        $size = round($disputes_file->getSize() / 1024, 2); //  in KB
                        $extension = $disputes_file->extension();
                        $lastModified = $disputes_file->getMTime();
                        if ($extension == 'heif') {
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                            $path = 'offers/' . $offer_id . '/disputes/'.$fileName;
    
                            $getSuppImageBlob = app('common')->heicToBlob($disputes_file->getPathName());
                            Storage::put($path, $getSuppImageBlob);
                        }else{                       
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                            $path = $disputes_file->storeAs('offers/' . $offer_id . '/disputes', $fileName);
                        }

                        DealsDisputes::create([
                            'offer_id' => $offer_id,
                            'disputes_note' => $disputes_note,
                            'file_name' => $name,
                            'file_size' => $size,
                            'file_extension' => $extension,
                            'file_last_modified' => $lastModified,
                            'file_path' => $path,
                        ]);
                    } else {
                        DealsDisputes::create([
                            'offer_id' => $offer_id,
                            'disputes_note' => $disputes_note,
                        ]);
                    }
                    $response = [
                        'status' => true,
                        'message' => __('Dispute report successfully'),
                        'data' => ['disputes_note' => $disputes_note]
                    ];
                }
                if($is_send_admin_notification == true) {
                    $user_obj = app('common')->getUserEmail(Auth()->user()->id);
                    $admin_obj = app('common')->getUserDetailsRoleBy(1);
                    
                    Notification::send($admin_obj, new NotificationAdminDealDisputesCreated($user_obj));
                }
                
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

    public function createCashed(Request $request, $slug)
    {
        $request->validate([
            'is_cashed' => 'required|in:Yes,No',
            'user_type' => 'required|in:Buyer,Seller',
            'data_step_id' => 'required',
            'cashed_date' => 'required',
            // 'cashed_date' => 'required|before:tomorrow',
        ]);
        
        if($request->ajax() && !empty($slug))
        {
            try {
                $is_cashed = $request->is_cashed;
                $user_type = $request->user_type;
                $data_step_id = $request->data_step_id;
                $cashed_date = $request->cashed_date;
                $cashed_date_ymd = Carbon::createFromFormat('d/m/Y', $cashed_date)->format('Y-m-d');

                $offer_result = Offer::where('slug', $slug)->first();
        
                if(!$offer_result) {
                    $response = [
                        'status' => false,
                        'message' => __('Record not found'),
                        'data' => []
                    ];
                    return response()->json($response);
                }

                $offer_id = $offer_result->id;
                
                $valid = false;
                
                if($user_type == 'Buyer') {

                    $offer_result->offer_status  = 'Completed';
                    $offer_result->is_cashed_buyer = 'Yes';
                    $offer_result->cashed_date_buyer = $cashed_date_ymd;
                    $offer_result->save();
                    $valid = true;

                    $buyer_obj = app('common')->getUserEmail($offer_result->buyer_id);

                    $buyer_link = route('deals.details', [$offer_result->slug, 'buyer']);
                    // Notification::send($buyer_obj, new NotificationOnceCashedInvestor(app()->getLocale()));

                    Mail::to($buyer_obj->email)->send(new DocumentCollectionAndReviewByBuyer($buyer_obj->name, $buyer_link));

                    app('common')->addLogs('document collection and review by buyer Email', $buyer_obj->id);
                    
                } else if($user_type == 'Seller') {

                    $offer_result->is_cashed_seller = 'Yes';
                    $offer_result->cashed_date_seller = $cashed_date_ymd;
                    $offer_result->save();
                    $valid = true;
                }

                if($valid) {

                    $step_id = $data_step_id;

                    $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
                    $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
                    $result_first = $all_tracking_steps->where('id', $step_id)->first();
                    $is_cashed = $result_first->cashed;
                    
                    if(isset($all_tracking_steps) && $step_id > 0 && $is_cashed  == 'Yes')
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

                    $response = [
                        'status' => true,
                        'message' => __('Cashed saved successfully'),
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
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function createFileUpload(Request $request)
    {
        $validated = $request->validate([
            'deals_user_type' => 'required|in:Buyer,Seller',
            'deals_slug' => 'required',
            'deals_file' => 'required|mimes:png,jpg,jpeg,pdf,heif',
            'data_step_id' => 'required',
            'upload_type' => 'required:in:deals,deals_attached_file',
        ]);

        $slug = $request->deals_slug;
        $deals_file = $request->deals_file;
        $deals_user_type = $request->deals_user_type;
        $data_step_id = $request->data_step_id;
        $upload_type = $request->upload_type;

        if($request->ajax() && !empty($slug))
        {
            try {
                $offer_result = Offer::where('slug', $slug)->select('id','slug')->first();
                
                if(!$offer_result) {
                    $response = [
                        'status' => false,
                        'message' => __('Record not found'),
                        'data' => []
                    ];
                    return response()->json($response);
                }

                $offer_id = $offer_result->id;

                $valid = false;
                if ($request->hasFile('deals_file') && $request->file('deals_file')->isValid()) {
                    if($deals_user_type == 'Seller') {
                        $deals_file = $request->file('deals_file');
                        $name = str_replace(' ', '_', $deals_file->getClientOriginalName());
                        $size = round($deals_file->getSize() / 1024, 2); //  in KB
                        $extension = $deals_file->extension();
                        $lastModified = $deals_file->getMTime();
                        if ($extension == 'heif') {
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                            $path = 'deals/' . $offer_id . '/documents/'.$fileName;
    
                            $getSuppImageBlob = app('common')->heicToBlob($deals_file->getPathName());
                            Storage::put($path, $getSuppImageBlob);
                        }else{                       
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                            $path = $deals_file->storeAs('deals/' . $offer_id . '/documents', $fileName);
                        }
                        
    
                        DealsDocuments::create([
                            'offer_id' => $offer_id,
                            'upload_type' => $upload_type,
                            'step_id' => $data_step_id,
                            'name' => $name,
                            'size' => $size,
                            'extension' => $extension,
                            'last_modified' => $lastModified,
                            'path' => $path,
                            'uploaded_by_name' => $deals_user_type,
                            'uploaded_by' => Auth()->user()?->id,
                        ]);
                        $valid = true;
                    } else if($deals_user_type == 'Buyer') {
                    /*  app('common')->fileDeleteFromFolder($offer_result->is_filed_buyer);
                        $offer_result->is_filed_buyer = $request->file('deals_file')->store('deals/' . $offer_result->id. '/Buyer');
                        $offer_result->save(); */
                        $deals_file = $request->file('deals_file');
                        $name = str_replace(' ', '_', $deals_file->getClientOriginalName());
                        $size = round($deals_file->getSize() / 1024, 2); //  in KB
                        $extension = $deals_file->extension();
                        $lastModified = $deals_file->getMTime();
                        if ($extension == 'heif') {
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                            $path = 'deals/' . $offer_id . '/documents/'.$fileName;
    
                            $getImageBlob = app('common')->heicToBlob($deals_file->getPathName());
                            Storage::put($path, $getImageBlob);
                        }else{                       
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                            $path = $deals_file->storeAs('deals/' . $offer_id . '/documents', $fileName);
                        }
                        
    
                        DealsDocuments::create([
                            'offer_id' => $offer_id,
                            'upload_type' => $upload_type,
                            'step_id' => $data_step_id,
                            'name' => $name,
                            'size' => $size,
                            'extension' => $extension,
                            'last_modified' => $lastModified,
                            'path' => $path,
                            'uploaded_by_name' => $deals_user_type,
                            'uploaded_by' => Auth()->user()?->id,
                        ]);
                        $valid = true;
                    }
                }

                if($valid) {

                    if($upload_type == 'deals') {

                        $step_id = $data_step_id;

                        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
                        $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
                        $result_first = $all_tracking_steps->where('id', $step_id)->first();
                        $is_file_upload= $result_first->file_upload;
                        
                        if(isset($all_tracking_steps) && $step_id > 0 && $is_file_upload == 'Yes')
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

                    $response = [
                        'status' => $valid,
                        'message' => __('File uploaded successfully'),
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
        } else {
            abort(404, 'Page not found!');
        }
    }
    
    public function ajaxPrivateNoteList(Request $request)
    {
        $deals_id = $request->deals_id;

        // $deals_private_notes = DealsPrivateNote::where('offer_id', $deals_id)->where('created_by', Auth()->user()?->id)->orderBy('id','desc')->get();
        $deals_private_notes = [];
    
        $dhtml = view('deals.ajax.ajax-deals-private-note-list', ['deals_private_notes' => $deals_private_notes])->render();
        
        $response = [
            'status' => true,
            'message' => __('Deals note list'),
            'data' => ['dhtml' => $dhtml]
        ];

        return response()->json($response);
    }
    public function ajaxPrivateNote(Request $request)
    {   
        $action = $request->deals_private_note_action;
        
        $required = "nullable";
        if($action == 'add' || $action == 'update') {
            $required = "required";
        }
        $validated = $request->validate([
            'deals_private_note_action' => 'required|in:add,update,delete',
            'deals_id' => 'required',
            'deals_private_note' => $required
        ]);

        $deals_id = $request->deals_id;
        
        $note = $request->deals_private_note ?? '';
        $note_id = $request->deals_private_note_id ?? '';
        DB::beginTransaction();
        try {
            if($action == 'add') {
                $save_note =  new DealsPrivateNote;
                $save_note->offer_id = $deals_id;
                $save_note->note = $note;
                $save_note->save();
                $msg = "Note saved successfully";
            } else if($action == 'update') {
                $update_note = DealsPrivateNote::where('id', $note_id)->where('offer_id', $deals_id)->first();
                $update_note->offer_id = $deals_id;
                $update_note->note = $note;
                $update_note->save();
                $msg = "Note updated successfully";
            } else if($action == 'delete') {
                $msg = "Note deleted successfully";
                $delete = DealsPrivateNote::where('id', $note_id)->where('offer_id', $deals_id)->delete();
            }
            $response = [
                'status' => true,
                'message' =>  __($msg),
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
    }

    public function ajaxDealsDocumentList(Request $request)
    {
        $validated = $request->validate([
            'deals_user_type' => 'required|in:Buyer,Seller',
            'deals_id' => 'required',
            'upload_type' => 'required:in:deals,deals_attached_file',
        ]);

        if($request->ajax())
        {
            try {
                $deals_id = $request->deals_id;
                $deals_user_type = $request->deals_user_type;
                $upload_type = $request->upload_type;
        
                $req_param['offer_id'] = $deals_id;
                $req_param['user_type'] = $deals_user_type;
                $req_param['upload_type'] = $upload_type;
        
                $result = app('deals')->getDealsDocumentBYOfferId($req_param);

                $dhtml = view('deals.ajax.ajax-deals-documnet-list', ['deals_documents' => $result])->render();
            
                $response = [
                    'status' => true,
                    'message' => __('Deals documents list'),
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

    public function dealsPaymentCheckout($slug, $step_id)
    {
        $offer = Offer::select(
            "offers.id", 
            "offers.slug",
            "offers.amount",
            "offers.mipo_commission", 
            "operations.operation_number", 
            "operations.operation_type"
        )
        ->leftJoin("offer_operations", "offer_operations.offer_id", "=", "offers.id")
        ->leftJoin("operations", "operations.id", "=", "offer_operations.operation_id")
        ->where('offers.slug', $slug)
        ->first();
    
        if(is_null($offer)) {
            abort(404, 'Page not found!');
        }

        $offer_id = $offer->id;

        /* start find step code */
        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
        if(isset($result_deals_tracking)) {
            
            $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
        
            if(isset($all_tracking_steps) && count($all_tracking_steps) > 0  && $step_id > 0) {
                $step_data_first = $all_tracking_steps->where('id', $step_id)->first();
                $is_payment = $step_data_first->payment;
            
                if($is_payment == 'Yes') {
                    Session::put('deal_step_id', $step_id);
                } else {
                    abort(404, 'Page not found!');
                }
            } else {
                abort(404, 'Page not found!');
            }
        } else {
            abort(404, 'Page not found!');
        }
        
        /* end find step code */
    
        $user = auth()->user();
        $deal = 'Deal:'.$offer->operation_type.' '.$offer->operation_number;
        $response = Bancard::singleBuy($deal, $offer->amount);
        if ($response->failed()) {
            return redirect()->back()->with('error','Something went wrong!');
            
        }
        $data = $response->json();
        $processId = $data['process_id'];
        $scriptUrl = Bancard::scriptUrl();
        Session::put('selectedDealsSlug', $slug);
        return view('user-deals-checkout', compact('processId', 'scriptUrl','offer','user'));
    }

    public function dealsMipoCommissionPaymentCheckout($slug, $step_id)
    {
        $offer = Offer::select(
            "offers.id", 
            "offers.slug",
            "offers.amount",
            "offers.mipo_commission", 
            "offers.mipo_plus_commission", 
            "operations.operation_number", 
            "operations.operation_type",
            "operations.preferred_currency"
        )
        ->leftJoin("offer_operations", "offer_operations.offer_id", "=", "offers.id")
        ->leftJoin("operations", "operations.id", "=", "offer_operations.operation_id")
        ->where('offers.slug', $slug)
        ->first();
    
        if(is_null($offer)) {
            abort(404, 'Page not found!');
        }

        $offer_id = $offer->id;

        /* start find step code */
        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
        if(isset($result_deals_tracking)) {
            
            $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
        
            if(isset($all_tracking_steps) && count($all_tracking_steps) > 0  && $step_id > 0) {
                $step_data_first = $all_tracking_steps->where('id', $step_id)->first();
                $is_payment = $step_data_first->mipo_commission_payment;
            
                if($is_payment == 'Yes') {
                    Session::put('deal_step_mipo_id', $step_id);
                } else {
                    abort(404, 'Page not found!');
                }
            } else {
                abort(404, 'Page not found!');
            }
        } else {
            abort(404, 'Page not found!');
        }
        
        /* end find step code */
    
        $user = auth()->user();
        $deal = 'Deal:'.$offer->operation_type.' '.$offer->operation_number;

        if($offer->mipo_plus_commission > 0 && $offer->mipo_commission > 0) {
            $total_amount = ($offer->mipo_plus_commission + $offer->mipo_commission);
        } else {
            $total_amount = ($offer->mipo_commission);
        }
        
        $response = Bancard::singleBuy($deal, $total_amount);
        if ($response->failed()) {
            return redirect()->back()->with('error','Something went wrong!');
            
        }
        $data = $response->json();
        $processId = $data['process_id'];
        $scriptUrl = Bancard::scriptUrl();
        Session::put('selectedMipoCommissionDealsSlug', $slug);
        return view('user-deals-checkout', compact('processId', 'scriptUrl','offer','user'));
    }

    public function ajaxMultipleFeedback(Request $request, $slug)
    {
        $request->validate([
            'feedback_ids' => 'required',
            'type' => 'required|in:cash_feedback,feedback',
        ],[
            'feedback' => "feedback is required"
        ]);
        
        $feedback_ids = $request->feedback_ids;

        $type = $request->type;

        $offer_result = Offer::where('slug', $slug)->first();

        $feedback_ids_arrs = explode(',', $feedback_ids);

        $feedback_ids_arr = array_map('trim', $feedback_ids_arrs);
    
        if(is_null($offer_result)) {
            $response = [
                'status' => false,
                'message' => __('Record not found'),
                'data' => []
            ];
            return response()->json($response);
        }

        $result = Offer::with([
            'buyer',  
            'operations' => function($qry) use ($feedback_ids_arr) {
                $qry->OperationSelect()
                ->whereIn('offer_operations.id', $feedback_ids_arr);
                $qry->with([
                    'seller',
                    'issuer',
                ]);
            },
            ])
            ->where('slug', $slug)
            ->first();
        
            $dhtml = view('deals.ajax.ajax-deal-feedback-multiple-modal',['deals_multiple_feedback_offers' => $result, 'feedback_ids' => $feedback_ids, 'type' => $type])->render();

            $response = [
                'status' => true,
                'message' => '',
                'data' => ['dhtml' => $dhtml]
            ];

            return response()->json($response);
    }

    public function ajaxCreateMultipleFeedback(Request $request, $slug)
    {

        $required = 'required';
        if($request->extis_date == 'yes') {
        $required = 'nullable';
        }

        $this->validate($request, [
            'type' => 'required|in:cash_feedback,feedback',
            'extis_date' => ['required', 'in:yes,no'],
            'offer_operation_id' => ['required', 'integer'],
            'offer_id' => ['required', 'integer'],
            'sell_feedback_rate' => ['required', 'min:1'],
            'pay_issuer_rate' => ['required', 'min:1'],
            'rate_user_id' => ['required'],
            'is_cashed_date' => $required,
        ],[
            'sell_feedback_rate' =>  'feedback rating is required',
            'pay_issuer_rate' =>  'Issuer rating is required',
            'rate_user_id' =>  'User is required',
            'is_cashed_date' =>  'Date is required',
        ]);

        DB::beginTransaction();
        try {
            if(Offer::where('id', $request->offer_id)->where('slug', $slug)->count() == 0) {
                $response = [
                    'status' => false,
                    'message' => __('Record not found'),
                    'data' => []
                ];
                return response()->json($response);
            }

            $is_exits = OfferOperation::where('id', $request->offer_operation_id)->where('offer_id', $request->offer_id)->where('is_offered', '1')->first();
    
            if(is_null($is_exits)) {

                $response = [
                    'status' => false,
                    'message' => __('Record not found'),
                    'data' => []
                ];

                return response()->json($response);
            }

            $is_exits->is_rated_buyer = 'Yes';
            if($request->extis_date == 'no' && $is_exits->is_cashed_buyer == 'No') {
            $is_exits->is_cashed_buyer = 'Yes';
            $is_exits->is_cashed_buyer_date = ($request->get('is_cashed_date', null)) ? Carbon::createFromFormat('d/m/Y', $request->input('is_cashed_date'))->format('Y-m-d') : null;
            }
            $is_exits->save();

            $user = User::where('id', $request->get('rate_user_id'))->select('id', 'slug', 'name')->first();

            if($user && $request->get('sell_feedback_rate') > 0) 
            {
                $save = new Rating();
                $save->ratingable_type = get_class($user);
                $save->ratingable_id = $user->id;
                $save->rating_number = $request->get('sell_feedback_rate');
                $save->feedback_transaction = $request->get('sell_trans_doctype');
                $save->feedback_document = $request->get('sell_doc_doctype');
                $save->feedback_cashing = $request->get('sell_auto_expire', 'No');
                $save->feedback_title = 1;
                $save->feedback_description = $request->get('sell_description');
                $save->save();
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Feedback rating field require'),
                    'data' => []
                ];
                return response()->json($response);
            }
    
            if($request->has('rate_issuer_id') && $request->get('pay_issuer_rate') > 0)
            {
                $issuer = Issuer::where('id',  $request->get('rate_issuer_id'))->first();
                if($issuer)
                {
                    $save = new Rating();
                    $save->ratingable_type = get_class($issuer);
                    $save->ratingable_id = $issuer->id;
                    $save->rating_number = $request->get('pay_issuer_rate');
                    $save->issuers_transaction = $request->get('pay_trans_doctype');
                    $save->issuers_document = $request->get('pay_doc_doctype');
                    $save->issuers_cashing = $request->get('pay_auto_expire', 'No');
                    $save->issuers_title = 1;
                    $save->issuers_description = $request->get('pay_description');
                    $save->save();
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Issuer rating field require'),
                    'data' => []
                ];
                return response()->json($response);
            }
            DB::commit();
            $response = [
                'status' => true,
                'message' => __('Rating added successfully'),
                'data' => []
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => false,
                'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                'data' => []
            ];
        }
        return response()->json($response);
    }
}
