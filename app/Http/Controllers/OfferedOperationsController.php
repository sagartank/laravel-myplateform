<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Offer;
use App\Models\Operation;
use App\Models\OfferOperation;
use App\Models\OffersHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CounterOfferReceivedbySeller;

class OfferedOperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        return view('offered-operations.index', ['currency_symblos' => $currency_symblos]);
    }

    public function ajaxLoadMoreOfferedOperationsList(Request $request)
    {
        if($request->ajax())
        {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $page = $request->input('page');
                $sort_type = $request->get('sort_type', 'ASC');
                $column_name = 'id';

                if ($sort_type == 'amount_asc') {
                    $column_name = 'amount';
                    $sort_type = 'ASC';
                } else if($sort_type == 'amount_desc') {
                    $column_name = 'amount';
                    $sort_type = 'DESC';
                }

                $req_param['sort_column'] = $column_name ;
                $req_param['sort_type'] = $sort_type;
                $req_param['per_page'] = config('constants.PER_PAGE');

                $offers = app('offer')->offeredOperationsWeb($req_param, $pagination = true);

                $dhtml = view('offered-operations.ajax.ajax-offered-operations-list', [
                    'offers' => $offers, 'currency_symblos' => $currency_symblos,
                    'user_id' => Auth()->user()->id,
                    'current_page' => $offers->currentPage(), 'last_page' => $offers->lastPage(), 'has_more_pages' => $offers->hasMorePages()
                    ])->render();
                
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

    public function ajaxUpdateOffer(Request $request)
    {
        $deal_mode = implode(',', config('constants.PREFERRED_MODE'));
        $validated = $request->validate([
            'offer_day_hour' => 'required|in:day,hour',
            'offer_amount' => 'required',   
            'deal_mode' => 'required|in:'.$deal_mode,
            'retention' => 'nullable|lt:offer_amount',
        ]);

        if($request->ajax())
        {
            try {
                $default_offer_time = config('constants.DEFAULT_OFFER_TIME');
                $offer_id = $request->get('offer_id');
                $seller_id = $request->get('seller_id', '');
                $operation_amount = $request->get('operation_amount', '');
                $retention = $request->get('retention');
                $preferred_payment_method = $request->get('deal_mode');
                $expires_at = $request->get('offer_till', 0);
                $offer_amount = $request->get('offer_amount');
                $operation_ids = $request->get('operation_id');
                $offer_day_hour = $request->get('offer_day_hour', 'hour');

                $update = Offer::where('id', $offer_id)->first();
                
                $req_param['offer_type'] = $update->offer_type;
                $req_param['operation_id'] = OfferOperation::where('offer_id', $offer_id)->select('operation_id')->pluck('operation_id')->toArray();
                $req_param['offer_amount'] = $offer_amount;
                $req_param['retention'] = $request->get('retention', '0');
                $req_param['is_mipo_plus'] = $request->get('is_mipo_plus', 'false');
                
                $calc_res =  app('common')->calculationForOffer($req_param, 'update_offer');
            
                $update->buyer_id  =  Auth()->user()->id;
                $update->preferred_payment_method  = $preferred_payment_method;
                $update->amount  = $offer_amount;
                $update->offer_status  = 'Pending';

                if(!is_null($expires_at) && $expires_at > 0) {
                    if($offer_day_hour == 'day') {
                        $update->expires_at = Carbon::now()->addDay($expires_at);
                    } else if($offer_day_hour == 'hour') {
                        $update->expires_at = Carbon::now()->addHour($expires_at);
                    } else {
                        $update->expires_at = Carbon::now()->addHour($default_offer_time);
                    }
                } else {
                    $update->expires_at = Carbon::now()->addHour($default_offer_time);
                }
            
                $update->retention  = $calc_res['retention'];
                $update->mipo_commission  = $calc_res['mipo_commission'];
                $update->mipo_plus_commission  = $calc_res['mipo_plus_commission'];
                $update->net_profit = $calc_res['net_profit'];
                $update->is_mipo_plus = $calc_res['is_mipo_plus'];
                $update->save();

                $offer_result = Offer::where('id', $offer_id)->with('operations:id,seller_id,operation_number')->select('id', 'slug', 'offer_status', 'buyer_id')->first();
            
                if($offer_result) {
                    
                    $seller_obj = app('common')->getUserEmail($offer_result->operations->first()->seller_id);

                    Mail::to($seller_obj->email)->send(new CounterOfferReceivedbySeller($seller_obj->name));
                }

                OffersHistory::create_offers_history($update);


                /* $update_offer_operation = OfferOperation::where('offer_id', $offer_id)->first();
                $update_offer_operation->offer_id = $offer_id;
                $update_offer_operation->offer_retention =  $calc_res['retention'];
                $update_offer_operation->offer_deal_mode = $preferred_payment_method;
                $update_offer_operation->offer_time	= ($expires_at);
                $update_offer_operation->offer_time_type = ucfirst($offer_day_hour);
                $update_offer_operation->offer_amount = $offer_amount;
                $update_offer_operation->offer_mipo_plus = $calc_res['is_mipo_plus'];
                $update_offer_operation->save(); */
                
                $response = [
                    'status' => true,
                    'message' => __('Offer updated successfully'),
                    'data' => $update
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

    public function ajaxOfferIdByList(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required',
            'currency_name' => 'required',
        ]);

        if($request->ajax())
        {
            try {
                
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $req_param['offer_id'] = $request->get('offer_id');
                $req_param['currency_name'] = $request->get('currency_name');
                $req_param['buyer_id'] = Auth()->user()->id;

                $offers_histories = OffersHistory::offers_id_by_list($req_param, $pagination = false);
                
                $dhtml = view('offered-operations.ajax.ajax-offered-history-list', [
                    'offers_histories' => $offers_histories, 
                    'currency_symblos' => $currency_symblos,
                    'currency_name' => $req_param['currency_name'],
                    ])->render();
                
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

    public function ajaxOfferById(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required',
            'action' => 'required|in:update,list',
        ]);

        if($request->ajax())
        {
            try {
                
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $req_param['offer_id'] = $request->get('offer_id');
                $req_param['action'] = $request->get('action');
                $req_param['buyer_id'] = Auth()->user()->id;

                $result = Offer::where('id', $req_param['offer_id'])
                ->with([
                    'operations',
                    'operations.issuer',
                    'operations.seller',
                    'operations.seller.city',
                    'operations.seller' => function ($qry) {
                        $qry->withAvg('ratings', 'rating_number');
                    },

                ])
                ->first();
            
                if(is_null($result)) 
                {
                    $response = [
                        'status' => false,
                        'message' => __('Record not found'),
                        'data' => []
                    ];
                }
                
                if($req_param['action'] == 'update') {
                    $investor_commission = app('common')->userPlan()->investor_commission;
                    $mipo_commission = app('common')->userPlan()->mipo_commission;

                    $dhtml = view('offered-operations.ajax.ajax-update-offer-modal', [
                        'result' => $result, 'currency_symblos' => $currency_symblos,
                        'mipo_commission' => $mipo_commission, 'investor_commission' => $investor_commission,
                        ])->render();
                } else if($req_param['action'] == 'list') {
                    $dhtml = view('offered-operations.ajax.ajax-offered-group-list', ['result' => $result, 'currency_symblos' => $currency_symblos])->render();
                }
                
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
}
