<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Offer;
use App\Models\Issuer;
use App\Models\Document;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Models\OperationsLogs;
use App\Models\OffersHistory;
use Illuminate\Support\Facades\DB;
use App\Models\CommercialReference;
use App\Models\SupportingAttachment;
use App\Http\Requests\OperationRequest;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Operator;
use Spatie\Tags\Tag;
use App\Models\DealsTracking;
use App\Models\IssuerBank;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\OperationFirstDocumentUpload as NotificationsOperationFirstDocumentUpload;
use App\Notifications\FirstDocumentUpload as NotificationsFirstDocumentUpload;
use App\Notifications\SecondDocumentUpload as NotificationsSecondDocumentUpload;
use App\Notifications\OperationStatusNotification as NotificationsAdminOperationStatusNotification;
use App\Imports\OperationsImports;
use Maatwebsite\Excel\Facades\Excel;
use Image;
use App\Models\OfferOperation;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        try {

            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $param = array();
            $param['user_id'] = Auth()->user()->id;
            $param['seller_id'] = Auth()->user()->id;
            $param['page_name'] = 'operations';
            
            $all_tags = \Spatie\Tags\Tag::get()->pluck('name', 'id')->toArray();

            $offers = Offer::with(['buyer', 'operations', 'operations.documents', 'operations.supportingAttachments'])
                ->whereHas('operations', function ($qry) {
                    $qry->where('seller_id', Auth()->user()->id);
                })->get();
                
            $offers_status_dashboard = app('dashboard')->offerStatus($param);
            
            $operations_status_dashboard = app('dashboard')->operationStatus($param);

            $deal_disputes_dashboard  = app('dashboard')->dealDisputesStatus($param);
            
            $average_retention = app('dashboard')->averageRetention($param);
            
            $average_operation_values = app('dashboard')->averageOperationValue($param);

            $average_rating_days = app('dashboard')->averageRatingDays($param);

            $average_discount = app('dashboard')->averageDiscount($param);

            $pichart_data = app('dashboard')->getUserProfilePichartData($param);
        
            $user = app('common')->publicProfileSeller(Auth()->user()->slug, $page_name ="operation_public_profile");
        
            $blogs = app('common')->publicProfileBlog($param);

            $data['currency_symblos'] = $currency_symblos;
            $data['all_tags'] = $all_tags;
            $data['offers'] = $offers;
            $data['offers_status_dashboard'] = $offers_status_dashboard;
            $data['operations_status_dashboard'] = $operations_status_dashboard;
            $data['deal_disputes_dashboard'] = $deal_disputes_dashboard;
            $data['average_discount'] = $average_discount;
            // $data['mi_operations_dashboard'] = $mi_operations_dashboard;
            $data['average_retention'] = $average_retention;
            $data['average_operation_values'] = $average_operation_values;
            $data['average_rating_days'] = $average_rating_days;
            $data['pichart_data'] = $pichart_data['data'] ?? [];
            $data['pichart_labels'] =  $pichart_data['labels'] ?? [];
            $data['user'] = $user;
            $data['blogs'] = $blogs;

            return view('operations.index', $data);

            } catch (\Exception $e) {
                // Handle the exception
                $message = $e->getMessage(); // Get the error message
                $line = $e->getLine(); // Get the line number where the exception occurred
                $file = $e->getFile(); // Get the file where the exception occurred

                // Log the error or handle it in your own way
                // For example:
                \Log::error("OperationController An exception occurred on line $line in file $file: $message");
            }
    }

    public function ajaxgetTags(Request $request)
    {
        if ($request->ajax()) {
            $all_tags = [];
            $search = $request->get('search');
            if ($search != '') {
                $result_data = \Spatie\Tags\Tag::select('name', 'id')
                    ->when($search, function ($qry) use ($search) {
                        if ($search != '') {
                            return $qry->where('name', 'like', '%' . $search . '%');
                        }
                    })->get()->pluck('name', 'id')->toArray();
                if (isset($result_data) && count($result_data) > 0) {
                    foreach ($result_data as $key => $val) {
                        $all_tags[] = [
                            'id' => $key,
                            'text' => $val,
                        ];
                    }
                }
            }

            $response = [
                'status' => true,
                'message' => '',
                'data' => $all_tags
            ];
            return response()->json($response);
        }
    }
    public function ajaxLoadMoreOffersList(Request $request)
    {
        $sort_type = $request->get('sort_type', 'ASC');

        if ($request->ajax()) {
            try {
                config(['database.connections.mysql.strict' => false]);
                DB::reconnect();
                
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');
                $offersSingle = Operation::join('offer_operations','operations.id','offer_operations.operation_id')
                ->join('offers','offer_operations.offer_id','offers.id')
                ->join('users','offers.buyer_id','users.id')
                ->join('issuers','operations.issuer_id','issuers.id')
                ->where('seller_id', Auth()->user()->id)
                ->where('offers.offer_type', 'Single')
                ->select(
                    'offers.*',
                    'operations.slug as operation_slug',
                    'operations.id as operation_id',
                    'operations.operation_number',
                    'operations.operation_type',
                    'operations.preferred_payment_method as operation_preferred_payment_method',
                    'operations.preferred_currency',
                    'operations.seller_id',
                    'operations.issuer_id',
                    'operations.responsibility',
                    'operations.amount as operation_amount',
                    'operations.amount_requested',
                    'operations.accept_below_requested',
                    'users.id AS user_id',
                    'users.name AS buyer_name',
                    'operations.id AS operations_ids',
                    'operations.amount AS operations_group_amount_sum',
                    'issuers.company_name AS issuer_name',
                    DB::raw('(SELECT COUNT(id) FROM documents WHERE operation_id = operations.id) AS operation_documents_count'),
                    DB::raw('(SELECT COUNT(id) FROM supporting_attachments WHERE operation_id = operations.id) AS supporting_attachments_count'),
                )
                ->where(['operations.seller_id' => Auth()->user()->id, 'offer_operations.is_offered' => '0'])
                ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                ->orderBy('offers.id', $sort_type)
                ->groupBy('operation_id');
                //->get();

                $offers = Operation::join('offer_operations','operations.id','offer_operations.operation_id')
                ->join('offers','offer_operations.offer_id','offers.id')
                ->join('users','offers.buyer_id','users.id')
                ->join('issuers','operations.issuer_id','issuers.id')
                ->where('seller_id', Auth()->user()->id)
                ->where('offers.offer_type', 'Group')
                ->select(
                    'offers.*',
                    'operations.slug as operation_slug',
                    'operations.id as operation_id',
                    'operations.operation_number',
                    'operations.operation_type',
                    'operations.preferred_payment_method as operation_preferred_payment_method',
                    'operations.preferred_currency',
                    'operations.seller_id',
                    'operations.issuer_id',
                    'operations.responsibility',
                    'operations.amount as operation_amount',
                    'operations.amount_requested',
                    'operations.accept_below_requested',
                    'users.id AS user_id',
                    'users.name AS buyer_name',
                    DB::raw('GROUP_CONCAT(operations.id) AS operations_ids'),
                    DB::raw('SUM(operations.amount) AS operations_group_amount_sum'),
                    'issuers.company_name AS issuer_name',
                    DB::raw('(SELECT COUNT(id) FROM documents WHERE operation_id = operations.id) AS operation_documents_count'),
                    DB::raw('(SELECT COUNT(id) FROM supporting_attachments WHERE operation_id = operations.id) AS supporting_attachments_count'),
                )
                ->where(['operations.seller_id' => Auth()->user()->id, 'offer_operations.is_offered' => '0'])
                ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                ->orderBy('offers.id', $sort_type)
                ->groupBy('offers.id')
                ->union($offersSingle)
                ->paginate($per_page);

                config(['database.connections.mysql.strict' => true]);
                DB::reconnect();

                $dhtml = view('operations.ajax.ajax-offers-list', [
                    'offers' => $offers, 
                    'currency_symblos' => $currency_symblos,
                    'current_page' => $offers->currentPage(), 
                    'last_page' => $offers->lastPage(), 
                    'has_more_pages' => $offers->hasMorePages()
                ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml]
                ];
            } catch (\Throwable $th) {
                info($th);
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
    public function ajaxLoadMoreOffersListOld(Request $request)
    {
        if ($request->ajax()) {
            try {

                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');
                $offersSingle = Offer::with([
                    'buyer' => function ($qry) {
                        $qry->select('id', 'name');
                    }, 'operations' => function ($qry) {
                        $qry->select(
                            'operations.slug',
                            'operations.id',
                            'operations.operation_number',
                            'operations.operation_type',
                            'operations.preferred_payment_method',
                            'operations.preferred_currency',
                            'operations.seller_id',
                            'operations.issuer_id',
                            'operations.responsibility',
                            'operations.amount',
                            'operations.amount_requested',
                            'operations.accept_below_requested',
                        );
                    },
                    'operations.issuer',
                    'operations.documents', 'operations.supportingAttachments'
                ])
                    ->whereHas('operations', function ($qry) {
                        $qry->where('seller_id', Auth()->user()->id)->groupBy('operations.id');
                    })
                    ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                    ->orderBy('id', 'desc')
                    ->where('offers.offer_type', 'Single');
                $offers = Offer::with([
                    'buyer' => function ($qry) {
                        $qry->select('id', 'name');
                    }, 'operations' => function ($qry) {
                        $qry->select(
                            'operations.slug',
                            'operations.id',
                            'operations.operation_number',
                            'operations.operation_type',
                            'operations.preferred_payment_method',
                            'operations.preferred_currency',
                            'operations.seller_id',
                            'operations.issuer_id',
                            'operations.responsibility',
                            'operations.amount',
                            'operations.amount_requested',
                            'operations.accept_below_requested',
                        );
                    },
                    'operations.issuer',
                    'operations.documents', 'operations.supportingAttachments'
                ])
                    ->whereHas('operations', function ($qry) {
                        $qry->where('seller_id', Auth()->user()->id);
                    })
                    ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                    ->orderBy('id', 'desc')
                    ->where('offers.offer_type', 'Group')
                    ->union($offersSingle)
                    ->paginate($per_page);

                $dhtml = view('operations.ajax.ajax-offers-list', [
                    'offers' => $offers, 
                    'currency_symblos' => $currency_symblos,
                    'current_page' => $offers->currentPage(), 
                    'last_page' => $offers->lastPage(), 
                    'has_more_pages' => $offers->hasMorePages()
                ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
    public function ajaxLoadMoreOffersListNew(Request $request)
    {
        if ($request->ajax()) {
            try {
                config(['database.connections.mysql.strict' => false]);
                DB::reconnect();

               

                  /*  dd($operation);
                $operation = Operation::select(DB::raw(" 
                SELECT op.operation_type,op.expiration_date,op.issuance_date,GROUP_CONCAT(DISTINCT op.id) AS operation_ids,
                GROUP_CONCAT(DISTINCT op.operation_number) AS operation_numbers,ofr.offer_type,op.amount as operation_amount,GROUP_CONCAT(DISTINCT ofr.id) AS offer_ids,op.responsibility,op.preferred_currency,issu.name as issuer_name"))
                ->join('issuers', 'issuers.id', '=', 'operations.issuer_id')
                //->join('offer_operations', 'offer_operations.id', '=', 'operations.id')
                ->join('offers', 'offers.id', '=', 'offer_operations.offer_id')
                ->join('offer_operations', function ($join) {
                    $join->on('offer_operations.id', '=', 'operations.id')
                    ->on('offer_operations.is_offered',0);
                })
                ->where('operations.seller_id', Auth()->user()->id)
                ->groupBy('offers.offer_type')
                ->get();

                $res = DB::select(DB::raw(" 
                SELECT op.operation_type,op.expiration_date,op.issuance_date,GROUP_CONCAT(DISTINCT op.id) AS operation_ids,
                GROUP_CONCAT(DISTINCT op.operation_number) AS operation_numbers,ofr.offer_type,op.amount as operation_amount,GROUP_CONCAT(DISTINCT ofr.id) AS offer_ids,op.responsibility,op.preferred_currency,issu.name as issuer_name
             FROM operations AS op
             INNER JOIN issuers AS issu ON op.issuer_id=issu.id
             INNER JOIN offer_operations AS ofrop ON op.id=ofrop.operation_id AND ofrop.is_offered = 0
             INNER JOIN offers AS ofr ON ofrop.offer_id=ofr.id AND ofr.offer_status != 'Approved'
             WHERE op.seller_id = 17 
             GROUP BY ofr.offer_type;"
                ));
                config(['database.connections.mysql.strict' => true]);
                DB::reconnect();
                dd($res);*/
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');

                $operationsU = Operation::select("operations.id AS id","operations.operation_type","operations.expiration_date","operations.issuance_date",DB::raw("GROUP_CONCAT(DISTINCT operations.id) AS operation_ids"),DB::raw("GROUP_CONCAT(DISTINCT operations.operation_number) AS operation_numbers"),"offers.offer_type","operations.amount as operation_amount",DB::raw("GROUP_CONCAT(DISTINCT offers.id) AS offer_ids"),"operations.responsibility","operations.preferred_currency","issuers.company_name as issuer_name",DB::raw("SUM(DISTINCT operations.amount) as operation_amounts"),"operations.preferred_payment_method","offers.expires_at")
                ->withCount(['documents','supportingAttachments'])
                    ->join('offer_operations', function ($join) {
                        $join
                        ->on('operations.id', '=', 'offer_operations.operation_id')
                        ->where('offer_operations.is_offered', 0);
                    })
                    ->join('offers', 'offer_operations.offer_id', '=', 'offers.id')
                    ->join('issuers', 'operations.issuer_id', '=', 'issuers.id')
                    ->where('operations.seller_id', Auth()->user()->id)
                    ->where('offers.offer_type', 'Group');
                    //->groupBy('offers.offer_type');

                $operations = Operation::select("operations.id AS id","operations.operation_type","operations.expiration_date","operations.issuance_date",DB::raw("GROUP_CONCAT(DISTINCT operations.id) AS operation_ids"),DB::raw("GROUP_CONCAT(DISTINCT operations.operation_number) AS operation_numbers"),"offers.offer_type","operations.amount as operation_amount",DB::raw("GROUP_CONCAT(DISTINCT offers.id) AS offer_ids"),"operations.responsibility","operations.preferred_currency","issuers.company_name as issuer_name",DB::raw("SUM(DISTINCT operations.amount) as operation_amounts"),"operations.preferred_payment_method","offers.expires_at")
                ->withCount(['documents','supportingAttachments'])
                ->join('offer_operations', function ($join) {
                    $join
                    ->on('operations.id', '=', 'offer_operations.operation_id')
                    ->where('offer_operations.is_offered', 0);
                })
                ->join('offers', 'offer_operations.offer_id', '=', 'offers.id')
                ->join('issuers', 'operations.issuer_id', '=', 'issuers.id')
                ->where('operations.seller_id', Auth()->user()->id)
                ->where('offers.offer_type', 'Single')
                ->groupBy('operations.id')
                ->union($operationsU)
                ->paginate($per_page);

                $offers = null;
                /*$offers = Offer::with([
                    'buyer' => function ($qry) {
                        $qry->select('id', 'name');
                    }, 'operations' => function ($qry) {
                        $qry->select(
                            'operations.slug',
                            'operations.id',
                            'operations.operation_number',
                            'operations.operation_type',
                            'operations.preferred_payment_method',
                            'operations.preferred_currency',
                            'operations.seller_id',
                            'operations.issuer_id',
                            'operations.responsibility',
                            'operations.amount',
                            'operations.amount_requested',
                            'operations.accept_below_requested',
                        );
                    },
                    'operations.issuer',
                    'operations.documents', 'operations.supportingAttachments'
                ])
                    ->whereHas('operations', function ($qry) {
                        $qry->where('seller_id', Auth()->user()->id);
                        $qry->where('is_offered', 0);
                    })
                    ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                    ->orderBy('id', 'desc')
                    ->paginate($per_page);*/

                $dhtml = view('operations.ajax.ajax-offers-list', [
                    'offers' => $offers, 
                    'operations' => $operations, 
                    'currency_symblos' => $currency_symblos,
                    'current_page' => $operations->currentPage(), 
                    'last_page' => $operations->lastPage(), 
                    'has_more_pages' => $operations->hasMorePages()
                ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxLoadMoreOperations(Request $request)
    {
        if ($request->ajax()) {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $page = $request->input('page');
                $sort_type = $request->get('sort_type', 'ASC');
                $column_name = 'id';
                
                if ($sort_type == 'amount_asc') {
                    $column_name = 'amount';
                    $sort_type = 'ASC';
                } else if ($sort_type == 'amount_desc') {
                    $column_name = 'amount';
                    $sort_type = 'DESC';
                }

                $req_param['operation_type'] = $request->get('operation_type');
                $req_param['preferred_currency'] = $request->get('preferred_currency');
                $req_param['responsibility'] = $request->get('responsibility');
                $req_param['preferred_payment_method'] = $request->get('preferred_payment_method');
                $req_param['operation_status'] = $request->get('operation_status');
                $req_param['add_tags'] = $request->get('add_tags');
                $req_param['offer_status'] = $request->get('offer_status');
                $req_param['duration_date_range'] = $request->get('duration_date_range', '');
                $req_param['search'] = $request->get('search', '');
                $req_param['search'] = $request->get('search', '');
                $req_param['sort_column'] = $column_name ;
                $req_param['sort_type'] = $sort_type;
                $req_param['per_page'] = config('constants.PER_PAGE');
                
                $operations = app('operation')->getAllOperationWeb($req_param, $pagination = true);

                $dhtml = view('operations.ajax.ajax-operations-list', [
                    'operations' => $operations, 'currency_symblos' => $currency_symblos,
                    'current_page' => $operations->currentPage(), 'last_page' => $operations->lastPage(), 'has_more_pages' => $operations->hasMorePages()
                    ])->render();
                
            /*   $operations_dashboard = '';  
            if( $request->get('operation_filter_dashboard') == true) {
                    $operations_dashboard = app('operation')->getOperationDashboardWeb($req_param, $pagination = false);
                }

                $operations_dashboard_dhtml = view('operations.ajax.ajax-operations-dashboard', [
                    'operations_dashboard' => $operations_dashboard, 'currency_symblos' => $currency_symblos,
                ])->render();
            */
                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml, 'operations_dashboard' => $operations_dashboard_dhtml = '']
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function operationDetail($slug)
    {
        try {
            $result = Operation::OperationSelect()
            ->with([
                'seller' => function ($qry) {
                    $qry->select('id', 'address_verify', 'issuer_id', 'slug', 'name','account_type', 'user_level', 'security_level', 'phone_number', 'city_id', 'profile_image', 'birth_date', 'registered_at', 'preferred_currency')
                    ->with('city:id,name')
                    ->with('issuer:id,company_name,slug,ruc_text_id,ruc_code_optional')
                    ->withAvg('ratings', 'rating_number')->withCount('ratings');
                }, 
                'issuer' => function ($qry) {
                    $qry->select('id','company_name', 'slug', 'ruc_text_id', 'issuers_image', 'registry_in_mipo', 'verified_address','ruc_code_optional')
                    ->withAvg('ratings', 'rating_number')->withCount('ratings');;
                },
                'tags',
                'documents' => fn($qry) => $qry->select('id', 'slug', 'name', 'display_name', 'operation_id', 'path'),
                'supportingAttachments' => fn($qry) => $qry->select('id', 'slug', 'name', 'display_name', 'operation_id', 'path'),
                'references',
                'offers'
                ])
                ->where('slug', $slug)->first();

            if ($result) {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                return view('operations.details', ['result' => $result, 'currency_symblos' => $currency_symblos]);
            } else {
                return redirect()->route('operations.index');
            }
        } catch (\Throwable $th) {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxFileExport(Request $request, $slug)
    {
        // if ($request->ajax()) {
            try {
                // ini_set('max_execution_time', 0);
                set_time_limit(300); 

                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        
                $result = app('operation')->getOperationById($operation_id = null, $slug);
                if($result)
                {
                    $data['operation'] = $result;
                    
                    $data['currency_symblos'] = $result;
            
                    $fileName = $result->operation_number.".pdf";

                    $pdf = Pdf::loadView('pdf.pdf-operation-details', $data);
                    
                    return $pdf->download($fileName);
                    
                    
                    /* $filePath = "/operationdata/pdf/";

                    $fileFullPath = storage_path('app'.$filePath.$fileName);

                    $headers = [
                        'Content-Type' => 'application/pdf',
                    ];
                    
                    $content = $pdf->download()->getOriginalContent();

                    Storage::put($filePath.$fileName, $content);

                    return response()->download($fileFullPath, $fileName, $headers)->deleteFileAfterSend(true);; */
                } else {
                    return redirect()->route('explore-operations.index')->with('error', 'something went wrong');
                    /* $response = [
                        'status' => false,
                        'message' => 'No file Downalod',
                        'data' => ''
                    ]; */
                }
            } catch (\Throwable $th) {
                return redirect()->route('explore-operations.index')->with('error', $th->getMessage() .'Line No. ' . $th->getLine());
            }
        /*     return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        } */
    }

    public function ajaxOperationsByOfferNew(Request $request)
    {
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $sort_type = $request->get('sort_type', 'ASC');
        $column_name = $request->get('sort_column', 'id');
        $operation_id = $request->get('operation_id');
        $operation_ids = explode(',',$request->get('operation_id'));
        $offer_type = $request->get('offer_type', 'single');
        $offer_id = $request->get('offer_id');
        $offerOperations = OfferOperation::select(
                        'offers.*',
                        'users.name as buyer_name',
                        'operations.id as  operations_id',
                        'operations.slug as operations_slug',
                        'operations.preferred_currency',
                        'operations.operation_number',
                        'operations.operation_type',
                        'operations.amount as operations_amount',
                        'operations.preferred_payment_method'
                    )
                    ->join('offers', 'offer_operations.offer_id', '=', 'offers.id')
                    ->join('operations', 'offer_operations.operation_id', '=', 'operations.id')
                    ->join('users', 'offers.buyer_id', '=', 'users.id')
                    ->whereIn('offer_operations.operation_id', $operation_ids)
                    ->where('operations.seller_id', Auth()->user()->id)
                    ->get();

        $offerOperationList = $offerOperations->groupBy('buyer_name')->all();

        $offers =  Offer::select(
            'offers.*',
            'users.name as buyer_name',
            'operations.id as  operations_id',
            'operations.slug as operations_slug',
            'operations.preferred_currency',
            'operations.operation_number',
            'operations.operation_type',
            'operations.amount as operations_amount',
            'operations.preferred_payment_method'
        )
            ->whereIn('offers.offer_status', ['Pending', 'Counter'])
            ->where('offers.offer_type', $offer_type)
            ->where('operations.seller_id', Auth()->user()->id)
            ->when($offer_type, function ($qry) use ($offer_type, $operation_id) {
                if ($offer_type == 'Group') {
                    $operation_ids = explode(',', $operation_id);
                    $qry->whereIn('operations.id', $operation_ids);
                } else {
                    $qry->where('operations.id', $operation_id);
                }
            })
            ->join('offer_operations', 'offer_operations.offer_id', 'offers.id')
            ->join('operations', 'operations.id', 'offer_operations.operation_id')
            ->join('users', 'users.id', 'offers.buyer_id')
            ->when($column_name, function ($qry) use ($sort_type, $column_name) {
                if ($column_name == 'amount') {
                    $qry->orderByRaw('CONVERT(offers.amount, SIGNED) ' . $sort_type);
                } else {
                    $qry->orderBy($column_name, $sort_type);
                }
            })->get();
        
        $dhtml_offers_high_low_amount = $dhtml_group_offer = '';
        $show_high_low_avg = false;

        if ($offer_type == 'Single') {
            $show_high_low_avg = true;
            $dhtml_offers_high_low_amount = view('operations.ajax.ajax-operations-high-low-amount', ['offers' => $offers, 'currency_symblos' => $currency_symblos])->render();
        } else if ($offer_type == 'Group') {
            $offers_details = app('offer')->offerDetailsById(['offer_id' => $offer_id]);
            $dhtml_group_offer = view('operations.ajax.ajax-send-offer-group', ['offers' => $offers, 'offers_details' => $offers_details, 'currency_symblos' => $currency_symblos,'offerOperationList'=>$offerOperationList])->render();
        }

        $line_chart_labels = $line_chart_data = [];

        foreach ($offers as $key => $val) {
            $line_chart_labels[] = ($key + 1);
            $line_chart_data[] = ($val->amount);
        }
        
        $line_chart_labels[] = (count($line_chart_labels) + 1);

        $response = [
            'status' => true,
            'message' => '',
            'data' => ['dhtml' => $dhtml_offers_high_low_amount, 'dhtml_group_offer' => $dhtml_group_offer, 'line_data' => $line_chart_data, 'line_labels' => $line_chart_labels, 'show_high_low_avg' => $show_high_low_avg, 'offer_type' => $offer_type]
        ];

        return response()->json($response);
    }
    public function ajaxOperationsByOffer(Request $request)
    {
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $sort_type = $request->get('sort_type', 'ASC');
        $column_name = $request->get('sort_column', 'id');
        $operation_id = $request->get('operation_id');
        $offer_type = $request->get('offer_type', 'single');
        $offer_id = $request->get('offer_id');

        $offers =  Offer::select(
            'offers.*',
            'users.name as buyer_name',
            'operations.id as  operations_id',
            'operations.slug as operations_slug',
            'operations.preferred_currency',
            'operations.operation_number',
            'operations.operation_type',
            'operations.amount as operations_amount',
            'operations.preferred_payment_method'
        )
            ->whereIn('offers.offer_status', ['Pending', 'Counter'])
            ->where('offers.offer_type', $offer_type)
            ->where('operations.seller_id', Auth()->user()->id)
            ->when($offer_type, function ($qry) use ($offer_type, $operation_id) {
                if ($offer_type == 'Group') {
                    $operation_ids = explode(',', $operation_id);
                    $qry->whereIn('operations.id', $operation_ids);
                } else {
                    $qry->where('operations.id', $operation_id);
                }
            })
            ->join('offer_operations', 'offer_operations.offer_id', 'offers.id')
            ->join('operations', 'operations.id', 'offer_operations.operation_id')
            ->join('users', 'users.id', 'offers.buyer_id')
            ->when($column_name, function ($qry) use ($sort_type, $column_name) {
                if ($column_name == 'amount') {
                    $qry->orderByRaw('CONVERT(offers.amount, SIGNED) ' . $sort_type);
                } else {
                    $qry->orderBy($column_name, $sort_type);
                }
            })->get();
        
        $dhtml_offers_high_low_amount = $dhtml_group_offer = '';
        $show_high_low_avg = false;

        if ($offer_type == 'Single') {
            $show_high_low_avg = true;
            
            $operation = app('operation')->getOperationById($operation_id);
        
            $dhtml_offers_high_low_amount = view('operations.ajax.ajax-operations-high-low-amount', 
            ['offers' => $offers, 'currency_symblos' => $currency_symblos, 'operation' => $operation])->render();

        } else if ($offer_type == 'Group') {
            $offers_details = app('offer')->offerDetailsById(['offer_id' => $offer_id]);
            $req_param['offer_id'] = $offer_id;

            $offers_histories = OffersHistory::offers_id_by_list($req_param, $pagination = false);

            $dhtml_group_offer = view('operations.ajax.ajax-send-offer-group',
            ['offers' => $offers, 'offers_details' => $offers_details, 'currency_symblos' => $currency_symblos, 'offers_histories' => $offers_histories])
            ->render();
        }

        $line_chart_labels = $line_chart_data = [];

        foreach ($offers as $key => $val) {
            $line_chart_labels[] = ($key + 1);
            $line_chart_data[] = ($val->amount);
        }
        
        $line_chart_labels[] = (count($line_chart_labels) + 1);

        $response = [
            'status' => true,
            'message' => '',
            'data' => ['dhtml' => $dhtml_offers_high_low_amount, 'dhtml_group_offer' => $dhtml_group_offer, 'line_data' => $line_chart_data, 'line_labels' => $line_chart_labels, 'show_high_low_avg' => $show_high_low_avg, 'offer_type' => $offer_type]
        ];

        return response()->json($response);
    }
    public function ajaxOperationsHighLowAmount(Request $request)
    {
    
        if ($request->ajax()) {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');

                $sort_type = $request->get('sort_type', 'ASC');
                $column_name = $request->get('sort_column', 'amount');
                $operation_id = $request->get('operation_id');
                $offer_type = $request->get('offer_type', 'single');

                $offers =  Offer::select(
                    'offers.*',
                    'users.name as buyer_name',
                    'operations.id as  operations_id',
                    'operations.preferred_currency',
                    'operations.operation_number',
                    'operations.operation_type',
                    'operations.amount as operations_amount',
                    'operations.preferred_payment_method'
                )
                    // ->where('offers.offer_status', 'Pending')
                    ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                    ->where('offers.offer_type', $offer_type)
                    ->where('operations.seller_id', Auth()->user()->id)
                    ->when($offer_type, function ($qry) use ($offer_type, $operation_id) {
                        if ($offer_type == 'group') {
                            $operation_ids = explode(',', $operation_id);
                            $qry->whereIn('operations.id', $operation_ids);
                        } else {
                            $qry->where('operations.id', $operation_id);
                        }
                    })
                    ->join('offer_operations', 'offer_operations.offer_id', 'offers.id')
                    ->join('operations', 'operations.id', 'offer_operations.operation_id')
                    ->join('users', 'users.id', 'offers.buyer_id')
                    ->when($column_name, function ($qry) use ($sort_type, $column_name) {
                        if ($column_name == 'amount') {
                            $qry->orderByRaw('CONVERT(offers.amount, SIGNED) ' . $sort_type);
                        } else {
                            $qry->orderBy($column_name, $sort_type);
                        }
                    })
                    ->get();
                
                $operation = app('operation')->getOperationById($operation_id);

                $dhtml_group_offer = $dhtml = '';
                if ($offer_type == 'Single') {
                    $dhtml = view('operations.ajax.ajax-operations-high-low-amount-sort-by', ['offers' => $offers, 'currency_symblos' => $currency_symblos, 'operation' => $operation])->render();
                    // $dhtml = view('operations.ajax.ajax-operations-high-low-amount', ['offers' => $offers, 'currency_symblos' => $currency_symblos, 'operation' => $operation])->render();
                }
                if ($offer_type == 'Group') {
                    $dhtml_group_offer = view('operations.ajax.ajax-send-offer-group', ['offers' => $offers, 'currency_symblos' => $currency_symblos, 'operation' => $operation])->render();
                }

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml, 'dhtml_group_offer' => $dhtml_group_offer]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxSingleOfferCounterPage(Request $request)
    {
        if ($request->ajax()) {
            try {
                $dhtml = '';
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $operation_id = $request->get('operation_id');
                $offer_id = $request->get('offer_id');
                $offer_type = $request->get('offer_type', 'Single');
                $offers = Offer::with([
                    'buyer' => function ($qry) {
                        $qry->select('id', 'name');
                    },
                    /* 'counter_offers' => function ($qry) use($offer_id) {
                        $qry->where('offer_id', $offer_id)->orderby('id','desc');
                    }, */
                    // 'offers_history',
                    'operations'
                ])
                    ->where('id', $offer_id)
                    ->where('offer_type', $offer_type)
                    // ->where('offer_status', 'Pending')
                    ->whereIn('offers.offer_status', ['Pending', 'Counter'])
                    ->first();

                    $req_param['offer_id'] = $offer_id;
                    $req_param['buyer_id'] = Auth()->user()->id;
    
                    $offers_histories = OffersHistory::offers_id_by_list($req_param, $pagination = false);

                if ($offers) {
                    $dhtml = view('operations.ajax.ajax-send-single-counter-offer', ['offers' => $offers, 'currency_symblos' => $currency_symblos, 'offers_histories' => $offers_histories])->render();
                    $response = [
                        'status' => true,
                        'message' => '',
                        'data' => ['dhtml' => $dhtml]
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('No offer found'),
                        'data' => ['dhtml' => '']
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::getActiveCompany();
        $issuerBanks = IssuerBank::getIssuerBank();
        return view('operations.create', [
                'companies' => $companies,
                'issuerBanks' => $issuerBanks,
            'issuers' => Issuer::select('company_name', 'ruc_text_id', 'id')->get(),
            // 'issuerBanks' => IssuerBank::select('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        /*  if($request->has('accept_below_requested') && $request->get('accept_below_requested') == '1') {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'accept_below_requested' => 'sometimes|in:1',
                'amount_requested' => 'required_if:accept_below_requested,1|numeric|lt:amount|min:0',
            ]);
        } else {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        } */
    
        if ($request->has('tnc') && $request->input('tnc') == 'on') {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        } else {
            $this->validate($request, [
                'amount' => 'nullable|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        }

        $send_email = true;
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');

        DB::beginTransaction();
        try {
            $operation = new Operation();
            $operation->operation_type = $request->input('doc_type');
            $operation->responsibility = $request->input('responsibility');
            $operation->preferred_payment_method = $request->input('preferred_payment_method');

            if ($operation->operation_type == 'Cheque') {
                $operation->check_number = $request->input('check_number');
                $operation->auto_expire = 0;
            } elseif ($operation->operation_type == 'Invoice') {
                $operation->invoice_type = $request->input('invoice_type');
                $operation->invoice_number = $request->input('invoice_number');
                $operation->issuer_company_type = $request->input('issuer_company_type');
                // $operation->tax_id = $request->input('tax_id');
                $operation->timbrado = $request->input('timbrado');
                $operation->authorized_personnel = $request->input('authorized_personnel');
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;

                $operation->stamp_expiration = $request->get('stamp_expiration') ? Carbon::createFromFormat('d/m/Y', $request->input('stamp_expiration'))->format('Y-m-d') : null;

            } elseif ($operation->operation_type == 'Contract') {
                $operation->is_government_contract = $request->input('is_government_contract');
                $operation->contract_title = $request->input('contract_title');
                $operation->issuer_company_type = $request->input('issuer_company_type');
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
                $operation->timbrado = $request->input('timbrado');
                $operation->contract_number = $request->input('contract_number');

                $operation->stamp_expiration = $request->get('stamp_expiration') ? Carbon::createFromFormat('d/m/Y', $request->input('stamp_expiration'))->format('Y-m-d') : null;

            } elseif ($operation->operation_type == 'Other') {
                $operation->is_government_contract = $request->input('is_government_contract');
                $operation->description = $request->input('description');
                $operation->contract_title = $request->input('contract_title');
                $operation->issuer_company_type = $request->input('issuer_company_type');
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
            }

            if($operation->operation_type != 'Cheque') {
                $extra_expiration_days = $request->input('extra_expiration_days', '');
                if(!empty($extra_expiration_days) && $extra_expiration_days > 0) {
                    $operation->extra_expiration_days = $extra_expiration_days;
                    $operation->expiration_date_document = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->addDays($extra_expiration_days)->format('Y-m-d') : null;
                } else {
                    $operation->expiration_date_document = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d') : null;
                }
            } else {
                $operation->expiration_date_document = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d') : null;
                $operation->extra_expiration_days = null;
            }

            $operation->seller_id = Auth()->user()->id;

            if ($request->input('issuer') !== null && $request->input('issuer') !== '') {
                /*    $issuer = Issuer::where('company_name', $request->input('issuer'))->first();
                if ($issuer === null) {
                    $issuer = Issuer::create(['company_name' => $request->input('issuer')]);
                }
                $operation->issuer_id = $issuer->id; */
                $operation->issuer_id = $request->input('issuer');
            }

            $operation->preferred_currency = $request->input('preferred_currency');
            $operation->amount = $request->input('amount');
            $operation->amount_requested = $request->input('amount_requested');
            $operation->accept_below_requested = $request->has('accept_below_requested') ? 1 : 0;
            // $operation->issuer_bank = $request->input('issuer_bank');

            if ($request->input('issuer_bank') !== null && $request->input('issuer_bank') !== '') {
            /*    $issuerBank = IssuerBank::where('name', $request->input('issuer_bank'))->first();
                if ($issuerBank === null) {
                    $issuerBank = IssuerBank::create(['name' => $request->input('issuer_bank')]);
                } */
                $operation->issuer_bank_id = $request->input('issuer_bank');
            }   
    
            $operation->issuance_date = ($request->get('issuance_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('issuance_date'))->format('Y-m-d') : null;
            $operation->expiration_date = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d') : null;

            $operation->expired_at = $operation->auto_expire ? $operation->expiration_date . ' 00:00:00' : null;
            $operation->legal_direction = $request->legal_direction;
            $operation->legal_telephone = $request->legal_telephone;

            $operation->save();

            // add operations logs
            if ($operation->operations_status != 'Approved') {

            /*  DealsTracking::TrackingAdd($operation->id);

                OperationsLogs::operationsAddLogs($operation->id, '1', '0', 'Seller');
                OperationsLogs::operationsAddLogs($operation->id, '2', '0', 'Seller'); */
            }

            if ($request->hasFile('authorized_personnel_signature') && $request->file('authorized_personnel_signature')->isValid()) {
                $extension = request()->file('authorized_personnel_signature')->extension();
                $name = str_replace(' ', '_', request()->file('authorized_personnel_signature')->getClientOriginalName());
                if ($extension == 'heif') {
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'operationdata/' . $operation->id . '/authorizedpersonnelsignature/'.$fileName;
                    $getImageBlob = app('common')->heicToBlob(request()->file('authorized_personnel_signature')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $operation->authorized_personnel_signature = $path;
                }else{ 
                    $operation->authorized_personnel_signature = request()->file('authorized_personnel_signature')->store('operationdata/' . $operation->id . '/authorizedpersonnelsignature');
                }
            }
            $operation->save();

            if ($request->has('tnc') && $request->input('tnc') == 'on') {
                $operation->operations_status = 'Pending';
                $operation->save();
            } else {
                $operation->operations_status = 'Draft';
                $operation->save();
            }

            /* if ($request->has('tags') && $request->input('tags') != null && !empty($request->input('tags'))) {
                $operation->attachTags($request->input('tags'));
            } */

            if ($request->has('references')) {
                foreach ($request->input('references') as $reference) {
                    $operation->references()->create([
                        'name' => $reference['name'],
                        'company_name' => $reference['company_name'],
                        'phone_number' => $reference['phone_number'],
                        'email' => $reference['email'],
                    ]);
                }
            }

            if ($request->hasFile('documents')) {
                $i = 0;
                foreach ($request->file('documents') as $documentFile) {
                    $name = str_replace(' ', '_', $documentFile->getClientOriginalName());
                    $displayName = $request->input('document_names')[$i];
                    $size = round($documentFile->getSize() / 1024, 2); //  in KB
                    $extension = $documentFile->extension();
                    $lastModified = $documentFile->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/'. $operation->id . '/documents/'.$fileName;
                        $getImageBlob = app('common')->heicToBlob($documentFile->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $documentFile->storeAs('operationdata/' . $operation->id . '/documents', $fileName);
                    }
                    Document::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'display_name' => $displayName,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);

                    $i++;
                }
            }

            if ($request->hasFile('supporting_attachments')) {
                $i = 0;
                foreach ($request->file('supporting_attachments') as $supportingAttachmentFile) {
                    $name = str_replace(' ', '_', $supportingAttachmentFile->getClientOriginalName());
                    $displayName = $request->input('supporting_attachment_names')[$i];
                    $size = round($supportingAttachmentFile->getSize() / 1024, 2); //  in KB
                    $extension = $supportingAttachmentFile->extension();
                    $lastModified = $supportingAttachmentFile->getMTime();
                    
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/'. $operation->id . '/supportingattachments/'.$fileName;

                        $getSuppImageBlob = app('common')->heicToBlob($supportingAttachmentFile->getPathName());
                        Storage::put($path, $getSuppImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $supportingAttachmentFile->storeAs('operationdata/' . $operation->id . '/supportingattachments', $fileName);
                    }
                    SupportingAttachment::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'display_name' => $displayName,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);

                    $i++;
                }
            }

            $documents = Document::where('operation_id', $operation->id)->get();
            $supportingAttachments = SupportingAttachment::where('operation_id', $operation->id)->get();
            $commercialReferences = CommercialReference::select('id', 'name', 'company_name', 'email', 'phone_number')->where('operation_id', $operation->id)->get();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'success' => 0,
                'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
            ];
            return response()->json($response);
        }

        try {
                $totalOperataion = app('operation')->totalOperationByUser($operation->seller_id);

                if($totalOperataion == 1 && $send_email == true) {
                    $user_obj = app('common')->getUserEmail($operation->seller_id);
                    Notification::send($user_obj, new NotificationsFirstDocumentUpload(app()->getLocale()));
                    app('common')->addLogs('send email user congratulations on your first document Upload', $user_obj->id);
                }

                if($totalOperataion == 2 && $send_email == true) {
                    $user_obj = app('common')->getUserEmail($operation->seller_id);
                    Notification::send($user_obj, new NotificationsSecondDocumentUpload(app()->getLocale()));
                    app('common')->addLogs('send email user congratulations on your second document Upload', $user_obj->id);
                }

                if($is_send_admin_notification == true && $operation->operations_status == 'Pending') {
                    $admin_obj = app('common')->getUserDetailsRoleBy(1);
                    Notification::send($admin_obj, new NotificationsAdminOperationStatusNotification($operation));
                }
            
            } catch (\Throwable $th) {
                $response = [
                    'success' => 0,
                    'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
                ];
                return response()->json($response);
            }

        $msg = "";
        if($operation->operations_status == 'Pending' || $operation->operations_status == 'Draft') {
            $msg =  __($operation->operations_status." Operation Successfully Saved");
        } else if($operation->operations_status == 'Pending') {
            $msg = __("Operation Sent for Verification");
        } else if($operation->operations_status == 'Approved') {
            $msg = __("Operation Sent for Verification");
        } else if($operation->operations_status == 'Rejected') {
            $msg = __("Operation Reverted from Verification");
        }
    
        $response = [
            'success' => 1,
            'message' => $msg,
            'operation' => $operation->slug,
            // 'redirectTo' => route('operations.index'),
            'documents' => $documents,
            'supportingAttachments' => $supportingAttachments,
            'commercialReferences' => $commercialReferences,
            'updateLink' => route('operations.update', $operation),
            'detailsLink' => route('operations.details', $operation->slug),
        ];
        return response()->json($response);
    }

    public function bulkUploadOperations(Request $request)
    {
        DB::beginTransaction();
        try {
            $importOperations = new OperationsImports;
            Excel::import($importOperations, $request->file('operation_xls'));        
            // $importRes = $importOperations->getDocumentAndAttechmentArray(); 
            // $documentFileNamArr = $importRes['documents'] ?? [];
            // $supportingAttachmentsFileNamArr = $importRes['supporting_attachments'] ?? [];
            
            /*if ($request->hasFile('operation_documents')) {
                foreach ($request->file('operation_documents') as $documentFile) {
                    $originalName = $documentFile->getClientOriginalName();
                    if(isset($documentFileNamArr[$originalName])){
                        $operationId = $documentFileNamArr[$originalName];
                        $folderName = 'documents';
                    }elseif(isset($supportingAttachmentsFileNamArr[$originalName])){
                        $operationId = $supportingAttachmentsFileNamArr[$originalName];
                        $folderName = 'supportingattachments';
                    }else{
                        $operationId = null;
                    }
                    if($operationId){
                        $extension = pathinfo('https://w3nuts.xyz/Mipo-Dev/public/images/logo.svg', PATHINFO_EXTENSION);
                        if($extension){
                            $fileName = basename('https://picsum.photos/id/237/200/300');  
                            $name = str_replace(' ', '_', $fileName);
                            $path = 'operationdata/' . $operationId . '/'.$folderName.'/'.$fileName;
                            $mime = Storage::disk('local')->mimeType($path);
                            $lastModified = Storage::disk('local')->lastModified($path);
                            $size = Storage::disk('local')->size($path);
                            
                            Storage::disk('local')->put($path, file_get_contents('https://arjunphp.com/wp-content/uploads/2015/06/arjunphp_laravel.png'));
                            Document::create([
                                'operation_id' => $operationId,
                                'name' => $name,
                                'display_name' => $fileName,
                                'size' => $size,
                                'extension' => $extension,
                                'last_modified' => $lastModified,
                                'path' => $path,
                                'uploaded_by' => Auth()->user()?->id,
                            ]);

                        }
                    }
                }
            }    */  

            DB::commit();
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            // $response = [
            //     'success' => 0,
            //     'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
            // ];
            return redirect()->back()->with('error',$th->getMessage() . 'Line No. ' . $th->getLine());
            //return response()->json($response);
        }
        // $response = [
        //     'success' => 1,
        //     'redirectTo' => route('operations.index'),
        //     'message' => 'Operations save successfully.',
        // ];
        return redirect()->route('operations.index')->with('success','Operations save successfully.');
        // return response()->json($response);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function show(Operation $operation)
    {
        $operation->load('seller:id,name', 'issuer:id,company_name,ruc_text_id', 'documents', 'supportingAttachments', 'tags', 'references');
        return view('operations.show', ['operation' => $operation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function edit(Operation $operation)
    {
        $operation->load('issuer', 'documents', 'supportingAttachments', 'references', 'tags');
        $companies = Company::getActiveCompany();
        $issuerBanks = IssuerBank::getIssuerBank();
        return view('operations.edit', [
            'operation' => $operation,
            'companies' => $companies,
            'issuerBanks' => $issuerBanks,
            // 'issuers' => Issuer::select('name')->get(),
            // 'issuerBanks' => IssuerBank::select('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Operation $operation)
    {   
        /* if($request->has('accept_below_requested') && $request->get('accept_below_requested') == '1') {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'accept_below_requested' => 'sometimes|in:1',
                'amount_requested' => 'required_if:accept_below_requested,1|numeric|lt:amount|min:0',
            ]);
        } else {
            $this->validate($request, [
                'amount' => 'required|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        } */

        if ($request->has('tnc') && $request->input('tnc') == 'on') {
            $this->validate($request, [
                'tnc' => 'required',
                'amount' => 'required|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        } else {
            $this->validate($request, [
                'amount' => 'nullable|numeric',
                'amount_requested' => 'nullable|numeric|lt:amount|min:0',
            ]);
        }

        $send_email = true;
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');

        DB::beginTransaction();
        try {
            $operation->operation_type = $request->input('doc_type');
            $operation->responsibility = $request->input('responsibility');
            $operation->preferred_payment_method = $request->input('preferred_payment_method');

            if ($operation->operation_type == 'Cheque') {
                $operation->check_number = $request->input('check_number');
                $operation->auto_expire = 0;
            } elseif ($operation->operation_type == 'Invoice') {
                $operation->invoice_type = $request->input('invoice_type');
                $operation->invoice_number = $request->input('invoice_number');
                $operation->issuer_company_type = $request->input('issuer_company_type');
                // $operation->tax_id = $request->input('tax_id');
                $operation->timbrado = $request->input('timbrado');
                $operation->authorized_personnel = $request->input('authorized_personnel');
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
                $operation->stamp_expiration = $request->get('stamp_expiration') ? Carbon::createFromFormat('d/m/Y', $request->input('stamp_expiration'))->format('Y-m-d') : null;
            } elseif ($operation->operation_type == 'Contract') {
                $operation->is_government_contract = $request->input('is_government_contract');
                $operation->contract_title = $request->input('contract_title');
                $operation->contract_number = $request->input('contract_number');
                $operation->issuer_company_type = $request->input('issuer_company_type');
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
                $operation->timbrado = $request->input('timbrado');
                $operation->stamp_expiration = $request->get('stamp_expiration') ? Carbon::createFromFormat('d/m/Y', $request->input('stamp_expiration'))->format('Y-m-d') : null;
            } elseif ($operation->operation_type == 'Other') {
                $operation->is_government_contract = $request->input('is_government_contract');
                $operation->description = $request->input('description');
                $operation->contract_title = $request->input('contract_title');
                $operation->issuer_company_type = $request->input('issuer_company_type');
                $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
            }

            if($operation->operation_type != 'Cheque') {
                $extra_expiration_days = $request->input('extra_expiration_days', '');
                if(!empty($extra_expiration_days) && $extra_expiration_days > 0) {
                    $operation->extra_expiration_days = $extra_expiration_days;
                    $operation->expiration_date_document = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->addDays($extra_expiration_days)->format('Y-m-d') : null;
                } else {
                    $operation->expiration_date_document = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d') : null;
                }
            } else {
                $operation->expiration_date_document = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d') : null;
                $operation->extra_expiration_days = null;
            }

            $operation->seller_id = Auth()->user()->id;

            if ($request->input('issuer') !== null && $request->input('issuer') !== '') {
            /*     $issuer = Issuer::where('company_name', $request->input('issuer'))->first();
                if ($issuer === null) {
                    $issuer = Issuer::create(['company_name' => $request->input('issuer')]);
                }
                $operation->issuer_id = $issuer->id; */

                $operation->issuer_id = $request->input('issuer');
            }

            $operation->preferred_currency = $request->input('preferred_currency');
            $operation->amount = $request->input('amount');
            $operation->amount_requested = $request->input('amount_requested');
            $operation->accept_below_requested = $request->has('accept_below_requested') ? 1 : 0;
            // $operation->issuer_bank = $request->input('issuer_bank');

            if ($request->input('issuer_bank') !== null && $request->input('issuer_bank') !== '') {
                /*   $issuerBank = IssuerBank::where('name', $request->input('issuer_bank'))->first();
                if ($issuerBank === null) {
                    $issuerBank = IssuerBank::create(['name' => $request->input('issuer_bank')]);
                } */
                $operation->issuer_bank_id = $request->input('issuer_bank');
            }
        
            $operation->issuance_date = ($request->get('issuance_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('issuance_date'))->format('Y-m-d') : null;
            $operation->expiration_date = ($request->get('expiration_date')) ? Carbon::createFromFormat('d/m/Y', $request->input('expiration_date'))->format('Y-m-d') : null;
            
            $operation->auto_expire = $request->has('auto_expire') ? 1 : 0;
            $operation->expired_at = $operation->auto_expire ? $operation->expiration_date . ' 00:00:00' : null;
            $operation->legal_direction = $request->legal_direction;
            $operation->legal_telephone = $request->legal_telephone;

            $operation->save();

            if ($request->hasFile('authorized_personnel_signature') && $request->file('authorized_personnel_signature')->isValid()) {
                if ($operation->authorized_personnel_signature && Storage::exists(storage_path('app/' . $operation->authorized_personnel_signature)))
                    Storage::delete($operation->authorized_personnel_signature);

                    $extension = request()->file('authorized_personnel_signature')->extension();
                    if ($extension == 'heif') {
                        $name = str_replace(' ', '_', request()->file('authorized_personnel_signature')->getClientOriginalName());
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/' . $operation->id . '/authorizedpersonnelsignature/'.$fileName;
                        $getImageBlob = app('common')->heicToBlob(request()->file('authorized_personnel_signature')->getPathName());
                        Storage::put($path, $getImageBlob);
                        $operation->authorized_personnel_signature = $path;
                    }else{                       
                        $operation->authorized_personnel_signature = request()->file('authorized_personnel_signature')->store('operationdata/' . $operation->id . '/authorizedpersonnelsignature');
                    }
            }
            $operation->save();

            if ($request->has('tnc') && $request->input('tnc') == 'on') {
                $operation->operations_status = 'Pending';
                $operation->save();
            } else {
                $operation->operations_status = 'Draft';
                $operation->save();
            }

            // $operation->syncTags($request->input('tags') ?? []);

            if (request()->has('references')) {
                // $references = array_map(function ($reference) use ($operation) {
                //     return array(
                //         'name' => $reference['name'],
                //         'company_name' => $reference['company_name'],
                //         'phone_number' => $reference['phone_number'],
                //         'email' => $reference['email'],
                //         'operation_id' => $operation->id,
                //     );
                // }, $request->input('references'));

                $referenceIds = array_filter(array_column($request->input('references'), 'id'));

                if (!empty($referenceIds)) {
                    CommercialReference::where('operation_id', $operation->id)->whereNotIn('id', $referenceIds)->delete();
                }

                foreach ($request->input('references') as $reference) {
                    CommercialReference::updateOrCreate(
                        ['id' => $reference['id'] ?? null],
                        [
                            'name' => $reference['name'],
                            'company_name' => $reference['company_name'],
                            'email' => $reference['email'],
                            'phone_number' => $reference['phone_number'],
                            'operation_id' => $operation->id,
                        ]
                    );
                }
            } else {
                CommercialReference::where('operation_id', $operation->id)->delete();
            }

            if ($request->hasFile('documents')) {
                $i = 0;
                foreach ($request->file('documents') as $documentFile) {
                    $name = str_replace(' ', '_', $documentFile->getClientOriginalName());
                    $displayName = $request->input('document_names')[$i];
                    $size = round($documentFile->getSize() / 1024, 2); //  in KB
                    $extension = $documentFile->extension();
                    $lastModified = $documentFile->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/' . $operation->id . '/documents/'.$fileName;

                        $getImageBlob = app('common')->heicToBlob($documentFile->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $documentFile->storeAs('operationdata/' . $operation->id . '/documents', $fileName);
                    }

                    Document::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'display_name' => $displayName,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);

                    $i++;
                }
            }

            if ($request->hasFile('supporting_attachments')) {
                $i = 0;
                foreach ($request->file('supporting_attachments') as $supportingAttachmentFile) {
                    $name = str_replace(' ', '_', $supportingAttachmentFile->getClientOriginalName());
                    $displayName = $request->input('supporting_attachment_names')[$i];
                    $size = round($supportingAttachmentFile->getSize() / 1024, 2); //  in KB
                    $extension = $supportingAttachmentFile->extension();
                    $lastModified = $supportingAttachmentFile->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'operationdata/' . $operation->id . '/supportingattachments/'.$fileName;

                        $getImageBlob = app('common')->heicToBlob($supportingAttachmentFile->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $supportingAttachmentFile->storeAs('operationdata/' . $operation->id . '/supportingattachments', $fileName);
                    }
                    

                    SupportingAttachment::create([
                        'operation_id' => $operation->id,
                        'name' => $name,
                        'display_name' => $displayName,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                        'uploaded_by' => Auth()->user()?->id,
                    ]);

                    $i++;
                }
            }

            $documents = Document::where('operation_id', $operation->id)->get();
            // if ($documents->isNotEmpty()) {
            //     $documentPreviews = view('operations.ajax.document-dropzone-previews', ['documents' => $documents])->render();
            // } else {
            //     $documentPreviews = '';
            // }
            $supportingAttachments = SupportingAttachment::where('operation_id', $operation->id)->get();
            $commercialReferences = CommercialReference::select('id', 'name', 'company_name', 'email', 'phone_number')->where('operation_id', $operation->id)->get();
              
            if($is_send_admin_notification == true && $operation->operations_status == 'Pending') {
                $admin_obj = app('common')->getUserDetailsRoleBy(1);
                Notification::send($admin_obj, new NotificationsAdminOperationStatusNotification($operation));
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'success' => 0,
                'message' => $th->getMessage(),
            ];
            return response()->json($response);
        }
        
        $msg = "Operation Updated Successfully";
        if($operation->operations_status == 'Pending' || $operation->operations_status == 'Draft') {
            $msg =  __($operation->operations_status." Operation Successfully Saved");
        } else if($operation->operations_status == 'Pending') {
            $msg = __("Operation Sent for Verification");
        } else if($operation->operations_status == 'Approved') {
            $msg = __("Operation Sent for Verification");
        } else if($operation->operations_status == 'Rejected') {
            $msg = __("Operation Reverted from Verification");
        }

        $response = [
            'success' => 1,
            'message' => $msg,
            'operation' => $operation->slug,
            // 'redirectTo' => route('operations.index'),
            'documents' => $documents,
            'supportingAttachments' => $supportingAttachments,
            'commercialReferences' => $commercialReferences,
            // 'documentPreviews' => $documentPreviews,
            'detailsLink' => route('operations.details', $operation->slug),
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation)
    {
        $operation->delete();

        return redirect()->route('operations.index');
    }

    public function ajaxDeleteAuthorizedPersonnelSignature(Request $request)
    {
        if ($request->ajax()) {
            try {
                $operation = Operation::select('id', 'authorized_personnel_signature')->where('slug', $request->input('slug'))->first();
                if ($operation && $operation->authorized_personnel_signature) {
                    if (Storage::exists($operation->authorized_personnel_signature)) {
                        Storage::delete($operation->authorized_personnel_signature);
                    }
                    $operation->authorized_personnel_signature = null;
                    $operation->save();
                }
            } catch (\Throwable $th) {
                throw $th;
                $response = [
                    'success' => 0,
                    'message' => $th->getMessage(),
                ];
            }
            $response = [
                'success' => 1,
                'message' => __('Authorized personnel signature deleted successfully'),
            ];
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxDeleteDocumentFile(Request $request)
    {
        if ($request->ajax()) {
            try {
                $document = Document::where('slug', $request->input('slug'))->first();
                if ($document) {
                    if (Storage::exists($document->path)) {
                        Storage::delete($document->path);
                    }
                    $document->delete();
                    $response = [
                        'success' => 1,
                        'message' => __('Document deleted successfully'),
                    ];
                } else {
                    $response = [
                        'success' => 0,
                        'message' => __('Document not found'),
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'success' => 0,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxDeleteSupportingAttachmentFile(Request $request)
    {
        if ($request->ajax()) {
            try {
                $supportingAttachment = SupportingAttachment::where('slug', $request->input('slug'))->first();
                if ($supportingAttachment) {
                    if (Storage::exists($supportingAttachment->path)) {
                        Storage::delete($supportingAttachment->path);
                    }
                    $supportingAttachment->delete();
                    $response = [
                        'success' => 1,
                        'message' => __('Supporting attachment deleted successfully'),
                    ];
                } else {
                    $response = [
                        'success' => 0,
                        'message' => __('Supporting attachment not found'),
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'success' => 0,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxUpdateDocumentDisplayName(Request $request)
    {
        if ($request->ajax()) {
            try {
                $document = Document::where('slug', $request->input('slug'))->first();
                if ($document) {
                    $document->display_name = $request->input('display_name');
                    $document->save();
                    $response = [
                        'success' => 1,
                        'message' => __('Document updated successfully'),
                    ];
                } else {
                    $response = [
                        'success' => 0,
                        'message' => __('Document not found'),
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'success' => 0,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxGetTagsList(Request $request)
    {
        $search = $request->input('query');
        $perPage = 10;

        try {
            $results = [];
            $tags = Tag::select('name')
                ->when($search, function ($qry) use ($search) {
                    $qry->where('name', 'like', '%' . $search . '%')
                        ->orWhere('slug', 'like', '%' . $search . '%');
                })
                ->paginate($perPage);

            foreach ($tags as $tag) {
                $results[] = [
                    'id' => $tag->name,
                    'text' => $tag->name,
                ];
            }
        } catch (\Throwable $th) {

            //throw $th;
            $response = [
                'success' => 0,
                'status' => $th->getCode(),
                'message' => $th->getMessage(),
            ];
            return response()->json($response);
        }

        $response = [
            'success' => 1,
            'message' => __('Tags loaded successfully'),
            'tags' => $tags,
            'results' => $results,
        ];
        return response()->json($response);
    }

    public function ajaxUpdateSupportingAttachmentDisplayName(Request $request)
    {
        if ($request->ajax()) {
            try {
                $supportingAttachment = SupportingAttachment::where('slug', $request->input('slug'))->first();
                if ($supportingAttachment) {
                    $supportingAttachment->display_name = $request->input('display_name');
                    $supportingAttachment->save();
                    $response = [
                        'success' => 1,
                        'message' => __('Supporting attachment updated successfully'),
                    ];
                } else {
                    $response = [
                        'success' => 0,
                        'message' => __('Supporting attachment not found'),
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'success' => 0,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxDeleteMultipleOperation(Request $request)
    {
        $this->validate($request, [
            'action' => 'required|in:single,multiple',
            'operation_ids' => 'required'
        ]);
        // dd('s');
        if ($request->ajax()) {
            try {
                $action = $request->input('action');
                $operation_ids = $request->input('operation_ids');
                $isDelete = false;
                if ($action == 'single' || $action == 'multiple') {
                    if(is_array($operation_ids) && isset($operation_ids)) {
                        foreach($operation_ids as $operation_id){
                            $isOperationCount = Operation::whereHas('offers', function($qry){
                                $qry->where('is_offered', '1');
                            })->where('id', $operation_id)->count();
                            if($isOperationCount == 0) {
                                $operation = Operation::where('id', $operation_id)->first();
                                $operation->offers()->delete();
                                $isDelete = $operation->delete();
                            }
                        }
                    } else {
                        $isOperationCount = Operation::whereHas('offers', function($qry){
                            $qry->where('is_offered', '1');
                        })->where('id', $operation_ids)->count();
                        if($isOperationCount == 0) {
                            $operation = Operation::where('id', $operation_ids)->first();
                            $operation->offers()->delete();
                            $isDelete = $operation->delete();
                        }
                    }
                }
                if ($isDelete) {
                    $response = [
                        'status' => true,
                        'message' => __('Operation deleted successfully'),
                        'redirect_url' => Route('operations.index')
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('The record could not be deleted because of an association'),
                        'redirect_url' => ''
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxUpdateStatusOperation(Request $request)
    {
        $this->validate($request, [
            'operations_status' => 'required|in:Draft',
            'operation_ids' => 'required'
        ]);

        if ($request->ajax()) {
            try {
                $operations_status = $request->input('operations_status');
                $operation_ids = $request->input('operation_ids');

                $result = Operation::whereIn('id', $operation_ids)->update(['operations_status' => $operations_status]);

                if ($result) {
                    $response = [
                        'status' => true,
                        'message' => __('Operations status changed successfully'),
                    ];
                }
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage(),
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function ajaxLoadMoreOffersContractList(Request $request)
    {
        if ($request->ajax()) {
            try {
                $currency_symblos = config('constants.CURRENCY_SYMBOLS');
                $per_page = config('constants.PER_PAGE');
                $offers = Offer::with([
                    'buyer' => function ($qry) {
                        $qry->select('id', 'name');
                    }, 'operations' => function ($qry) {
                        $qry->select(
                            'operations.slug',
                            'operations.id',
                            'operations.operation_number',
                            'operations.operation_type',
                            'operations.preferred_payment_method',
                            'operations.preferred_currency',
                            'operations.seller_id',
                            'operations.issuer_id',
                            'operations.responsibility',
                            'operations.amount',
                            'operations.amount_requested',
                            'operations.accept_below_requested',
                        );
                    },
                    'operations.issuer',
                    'operations.documents', 'operations.supportingAttachments'
                ])
                    ->whereHas('operations', function ($qry) {
                        $qry->where('seller_id', Auth()->user()->id);
                    })
                    ->whereIn('offers.offer_status', ['Approved'])
                    ->where('offers.is_buyer_deals_contract', 'Yes')
                    ->where('offers.is_seller_deals_contract', 'No')
                    ->orderBy('id', 'desc')
                    ->paginate($per_page);

                $dhtml = view('operations.ajax.ajax-offer-contract-list', [
                    'offers' => $offers, 
                    'currency_symblos' => $currency_symblos,
                    'current_page' => $offers->currentPage(), 
                    'last_page' => $offers->lastPage(), 
                    'has_more_pages' => $offers->hasMorePages()
                ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function bulkUpload()
    {
        $companies = Company::getActiveCompany();
        $issuerBanks = IssuerBank::getIssuerBank();
        return view('operations.bulk-upload', [
                'companies' => $companies,
                'issuerBanks' => $issuerBanks,
        ]);
    }
    // public function ajaxGetBulkUploadModal(){
    //     $view = view('operations.modal.bulk-upload-modal')->render();
    //     return response()->json([
    //         'status' => true,
    //         'view' => $view
    //     ]);
    // }

    public function ajaxAddPayerIssuer(Request $request)
    {
        $this->validate($request, [
            'ruc' => 'required|min:2|unique:issuers,ruc_text_id',
            'name' => 'required|min:2',
            'payer_type' => 'required|in:business,person'
        ]);

        try {
            $payer_type = $request->payer_type;
            if($payer_type == 'business') {
                $issuer = Issuer::create(['company_name' => $request->input('name'), 'ruc_text_id' => $request->input('ruc'), 'ruc_code_optional' => $request->input('dv')]);
            } else if($payer_type == 'person') { 
                $issuer = Issuer::create(['first_name' => $request->input('name'), 'last_name' => $request->input('last_name') , 'ruc_text_id' => $request->input('ruc'), 'ruc_code_optional' => $request->input('dv')]);
            }
        
            if($issuer) {
                
                $ruc_text_id_code = ($issuer->ruc_code_optional) ?  $issuer->ruc_text_id .'-'. $issuer->ruc_code_optional : $issuer->ruc_text_id;

                $response = [
                    'status' => true,
                    'message' => __('Added successfully'),
                    'data' => ['id' => $issuer->id, 'issuer_name' => $issuer->company_name, 'ruc' => $ruc_text_id_code ]
                ];
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function ajaxPayerIssuerList(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('query');
            $results = [];
            try {
                if(!empty($search)) {
                    $issuers = Issuer::select('id', 'company_name', 'ruc_text_id', 'ruc_code_optional')
                    ->when($search, function ($qry) use ($search) {
                        $qry->where('company_name', 'like', '%' . $search . '%')
                        ->orWhere('ruc_text_id', 'like', '%' . $search . '%');
                    })->get();
                    
                    foreach ($issuers as $issuer) {
                        
                        $ruc_text_id_code = ($issuer->ruc_code_optional) ?  $issuer->ruc_text_id .'-'. $issuer->ruc_code_optional : $issuer->ruc_text_id;

                        $results[] = [
                            'id' => $issuer->id,
                            'text' => $issuer->company_name .' '. $ruc_text_id_code,
                        ];
                    }
                }

                $response = [
                    'status' => true,
                    'message' => __('Issuer loaded successfully'),
                    'results' => $results,
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'results' => []
                ];
            }
            return response()->json($response);
        }
    }
}
