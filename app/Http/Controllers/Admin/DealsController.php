<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Offer;
use App\Models\OperationProgress;
use App\Models\OperationsLogs;
use App\Models\DealsTracking;
use App\Models\DealsDisputes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Exports\DealsExport;
use App\Models\DealsSeog;
use App\Models\Document;
use App\Models\SupportingAttachment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\DealsPrivateNote;

class DealsController extends Controller
{
    public $toggle_column_names = ['seller_name' => 'Seller Name',  'opt_number' => "Operation Number", 'doc_amount' => 'Document Amount', 
    'deal_amount' => "Deal Amount", 'retention' => 'Retention', 'mi_coins_seller' => "MI Coins (Seller)" , 'mi_coins_buyer' => 'MI Coins (Buyer)'];

    function __construct()
    {
        $this->middleware('permission:deal_master|export-deal|view-deal|back-forward-seller-deal|back-forward-buyer-deal|deal-export-to-pdf', ['only' => ['index','show']]);
        $this->middleware('permission:export-deal', ['only' => ['Export']]);
        $this->middleware('permission:view-deal', ['only' => ['Details']]);
        $this->middleware('permission:back-forward-seller-deal|back-forward-buyer-deal', ['only' => ['dealsChangeStatus']]);
    }
    public function index()
    {
        $data['deals_column_names'] = $this->toggle_column_names;
        return view('admin.deals.index', $data);
    }

    public function ajaxLoadDealsData(Request $request){
        
        $param = $request->all();
        $perPage = $request->input('per_page') ?? config('constants.PER_PAGE_ADMIN');
        $sortType = $request->input('sort_type') ?? 'DESC';
        $sortColumn = $request->input('sort_column',) ?? 'id';
        $column_names = $request->input('column_names') ?? [];
        $data = app('deals')->getAll($param);
        
        return view('admin.deals.ajax.deals-data-table', ['data' => $data, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage, 'column_names' => $column_names]);
    }

    public function Details(Request $request, $slug)
    {
        $result = Offer::select('id','slug', 'is_disputed', 'is_rated_buyer', 'is_cashed_buyer', 'is_rated_seller', 'is_cashed_seller', 'offer_status', 'updated_at')->where('slug', $slug)->first();
        
        if(!$result) {
            return redirect()->route('admin.deals.index')->with('error', 'No record found');
        }

        $param['offer_id'] = $result->id;

        $result_deals = app('deals')->getDetails($param);
    
        $operation_id = $result_deals->operations->first()->pivot->operation_id;
        
        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($param['offer_id']);

        $offers_logs = app('deals_tracking')->getDealsTrackingLogs($param['offer_id']);

        $operation_ids = $result_deals->operations->pluck('pivot')->pluck('operation_id')->toArray();

        $deals_private_notes = DealsPrivateNote::where('offer_id', $result->id)->where('created_by', Auth()->user()?->id)->orderBy('id','desc')->get();

        $data['langs'] = (config('constants.languages.' . App()->getLocale()) == 'English') ? 'en' : 'es';
        $data['details'] = $result_deals;
        $data['offer'] = $result;
        $data['supporting_attachments'] = SupportingAttachment::whereIn('operation_id', $operation_ids)->get();
        $data['documents'] = Document::whereIn('operation_id', $operation_ids)->get();
        $data['seller_steps'] = $result_deals_tracking['seller_steps'] ?? [];
        $data['buyer_steps'] = $result_deals_tracking['buyer_steps'] ?? [];
        $data['offers_logs'] = $offers_logs;
        $data['buyer_steps_es'] = $result_deals_tracking['buyer_steps']->pluck('title_es', 'title_en');
        $data['seller_steps_es'] = $result_deals_tracking['seller_steps']->pluck('title_es', 'title_en');
        $data['deals_private_notes'] = $deals_private_notes;
    
        return view('admin.deals.details', $data);

    }

    public function dealsChangeStatus(Request $request)
    {
        $validated = $request->validate([
            'action_name' => 'required|in:back,forward',
            'operation_id' => 'required',
            'offer_id' => 'required',
            'step_name' => 'required',
            'step_type' => 'required',
            'step_id' => 'required',
        ]);
        
        $action_name = $request->get('action_name');
        $operation_id = $request->get('operation_id');
        $offer_id = $request->get('offer_id');
        $log_type = $request->get('step_type');  // as  seller, buyer
        $step_name_req = $request->get('step_name');  // as step title
        $step_id = $request->get('step_id');
        $step_links_ids = $request->has('step_links_ids') ? json_decode($request->get('step_links_ids')) : [];
        
        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
    
        $next_back_buyer_ids = $next_back_seller_ids = [];
        
        if($action_name == 'back') {

            OperationsLogs::where([
                'offer_id' => $offer_id,
                'title'=> $step_name_req,
                'log_types'=> $log_type
                ])->where('title', $step_name_req)->delete();

            $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->update(['is_current' => 0, 'is_completed' => 1]);

            $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->orderBy('id', 'desc')->first();
            
            if($is_exist) {
                $is_exist->is_current = 1;
                $is_exist->is_completed = 1;
                $is_exist->log_types = $log_type;
                $is_exist->offer_id = $offer_id;
                $is_exist->user_ip_address = \Request::userAgent();
                $is_exist->user_device = \Request::ip();
                $is_exist->completed_at = Carbon::now();
                $is_exist->save();
            }

            if($log_type == 'Seller') {
                $next_back_seller_ids[]= (int) $step_id;
            } else if($log_type =='Buyer') {
                $next_back_buyer_ids[]= (int) $step_id;
            }

            if($request->has('step_links_ids')){
                $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
                    if($step_links_ids && count($step_links_ids) > 0) {
                        foreach($step_links_ids as $step_links_id) {

                            $step_name = $all_tracking_steps->where('id', $step_links_id)->first()->title_en;
                            $step_type = $all_tracking_steps->where('id', $step_links_id)->first()->step_type;

                            if($step_type == 'Buyer') {
                                $next_back_buyer_ids[]= (int) $step_links_id;
                            } else if($step_type == 'Seller'){
                                $next_back_seller_ids[]= (int) $step_links_id;
                            }

                            $step_name_title = $all_tracking_steps->where('id', $step_links_id)->where('step_type', $step_type)->first()->title_en;

                            OperationsLogs::where([
                                'offer_id' => $offer_id,
                                'title'=> $step_name_title,
                                'log_types'=> $step_type,
                                ])->where('title', $step_name_title)->delete();

                                $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $step_type)->update(['is_current' => 0, 'is_completed' => 1]);

                                $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $step_type)->orderBy('id', 'desc')->first();
                                
                                if($is_exist) {
                                    $is_exist->is_current = 1;
                                    $is_exist->is_completed = 1;
                                    $is_exist->log_types = $step_type;
                                    $is_exist->offer_id = $offer_id;
                                    $is_exist->user_ip_address = \Request::userAgent();
                                    $is_exist->user_device = \Request::ip();
                                    $is_exist->completed_at = Carbon::now();
                                    $is_exist->save();
                                }
                        }
                } 
            }

            $response = [
                'status' => true,
                'message' => '',
                'data' =>  ['prev_title' => app('common')->removeSpecialChars($step_name_req), 'next_title' => app('common')->removeSpecialChars($step_name_req), 'step' => 'back', 'next_back_buyer_ids' => $next_back_buyer_ids, 'next_back_seller_ids' => $next_back_seller_ids],
            ];

        } else if($action_name == 'forward') {
        
            $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->update(['is_current' => 0, 'is_completed' => 1]);

            $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->where('title', $step_name_req)->orderBy('id', 'desc')->first();
            
            if(!$is_exist)
            {
                $is_exist = new OperationsLogs;
            }
            $is_exist->operation_id = $operation_id;
            $is_exist->title = $step_name_req;
            $is_exist->is_current = 1;
            $is_exist->is_completed = 1;
            $is_exist->offer_id = $offer_id;
            $is_exist->log_types = $log_type;
            $is_exist->user_ip_address = \Request::userAgent();
            $is_exist->user_device = \Request::ip();
            $is_exist->completed_at = Carbon::now();
            $is_exist->save();

            if($log_type == 'Seller') {
                $next_back_seller_ids[]= (int) $step_id;
            } else if($log_type =='Buyer') {
                $next_back_buyer_ids[]= (int) $step_id;
            }

            if($request->has('step_links_ids')) {
                $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
            
                    if($step_links_ids && count($step_links_ids) > 0) {
                        foreach($step_links_ids as $step_links_id) {

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
                            
                            $is_exist->operation_id = $operation_id;
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
                'message' => '',
                'data' =>  ['next_title' => app('common')->removeSpecialChars($step_name_req), 'step' => 'forward' , 'next_back_buyer_ids' => $next_back_buyer_ids, 'next_back_seller_ids' => $next_back_seller_ids],
            ];
        }

        return response()->json($response);
    }

    public function dealsChangeStatus_old(Request $request)
    {
        $validated = $request->validate([
            'action_name' => 'required|in:back,forward',
            'operation_id' => 'required',
            'offer_id' => 'required',
            'step_name' => 'required',
            'step_type' => 'required',
            'step_id' => 'required',
        ]);

        $action_name = $request->get('action_name');
        $operation_id = $request->get('operation_id');
        $offer_id = $request->get('offer_id');
        $log_type = $request->get('step_type');
        $step_name = $request->get('step_name');
        $step_id = $request->get('step_id');
        $step_links_ids = $request->has('step_links_ids') ? json_decode($request->get('step_links_ids')) : [];
        
        $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);

        $next_back_buyer_ids = $next_back_seller_ids = [];
        
        if($action_name == 'back') {
            OperationsLogs::where([
                'offer_id' => $offer_id,
                'title'=> $step_name,
                'log_types'=> $log_type
                ])->where('title', $step_name)->delete();

            $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->update(['is_current' => 0, 'is_completed' => 1]);

            $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->orderBy('id', 'desc')->first();
            
            if($is_exist) {
                $is_exist->is_current = 1;
                $is_exist->is_completed = 1;
                $is_exist->log_types = $log_type;
                $is_exist->offer_id = $offer_id;
                $is_exist->completed_at = Carbon::now();
                $is_exist->save();
            }

            if($log_type == "Seller") {
                if($request->has('step_links_ids')){
                    $buyer_steps = $result_deals_tracking['buyer_steps'] ?? [];
                        if($step_links_ids && count($step_links_ids) > 0) {
                            foreach($step_links_ids as $step_links_id) {
                                $next_back_buyer_ids[]= (int) $step_links_id;
                                $step_name_buyer = $buyer_steps->where('id', $step_links_id)->where('step_type', 'Buyer')->first()->title_en;

                                OperationsLogs::where([
                                    'offer_id' => $offer_id,
                                    'title'=> $step_name_buyer,
                                    'log_types'=> 'Buyer'
                                    ])->where('title', $step_name_buyer)->delete();

                                    $update_status_all_buyer = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->update(['is_current' => 0, 'is_completed' => 1]);

                                    $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->orderBy('id', 'desc')->first();
                                    
                                    if($is_exist) {
                                        $is_exist->is_current = 1;
                                        $is_exist->is_completed = 1;
                                        $is_exist->log_types = 'Buyer';
                                        $is_exist->offer_id = $offer_id;
                                        $is_exist->completed_at = Carbon::now();
                                        $is_exist->save();
                                    }
                            }
                    } 
                }
            } else if($log_type == "Buyer") {
                if($request->has('step_links_ids')){
                    $seller_steps = $result_deals_tracking['seller_steps'] ?? [];
                        if($step_links_ids && count($step_links_ids) > 0) {
                            foreach($step_links_ids as $step_links_id) {
                                $next_back_seller_ids[]= (int) $step_links_id;
                                $step_name_seller = $seller_steps->where('id', $step_links_id)->where('step_type', 'Seller')->first()->title_en;

                                OperationsLogs::where([
                                    'offer_id' => $offer_id,
                                    'title'=> $step_name_seller,
                                    'log_types'=> 'Seller'
                                    ])->where('title', $step_name_seller)->delete();

                                    $update_status_all_seller = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->update(['is_current' => 0, 'is_completed' => 1]);

                                    $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->orderBy('id', 'desc')->first();
                                    
                                    if($is_exist) {
                                        $is_exist->is_current = 1;
                                        $is_exist->is_completed = 1;
                                        $is_exist->log_types = 'Seller';
                                        $is_exist->offer_id = $offer_id;
                                        $is_exist->completed_at = Carbon::now();
                                        $is_exist->save();
                                    }
                            }
                    } 
                }
            }
        
            $response = [
                'status' => true,
                'message' => '',
                'data' =>  ['prev_title' => app('common')->removeSpecialChars($step_name), 'next_title' => app('common')->removeSpecialChars($step_name), 'step' => 'back', 'next_back_buyer_ids' => $next_back_buyer_ids, 'next_back_seller_ids' => $next_back_seller_ids],
            ];

        } else if($action_name == 'forward') {
            $update_status_all = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->update(['is_current' => 0, 'is_completed' => 1]);

            $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', $log_type)->where('title', $step_name)->orderBy('id', 'desc')->first();
            
            if(!$is_exist)
            {
                $is_exist = new OperationsLogs;
            }
            $is_exist->operation_id = $operation_id;
            $is_exist->title = $step_name;
            $is_exist->is_current = 1;
            $is_exist->is_completed = 1;
            $is_exist->offer_id = $offer_id;
            $is_exist->log_types = $log_type;
            $is_exist->completed_at = Carbon::now();
            $is_exist->save();

            if($log_type == "Seller") {
                if($request->has('step_links_ids')){
                    $buyer_steps = $result_deals_tracking['buyer_steps'] ?? [];
                        if($step_links_ids && count($step_links_ids) > 0) {
                            foreach($step_links_ids as $step_links_id) {
                                $next_back_buyer_ids[]= (int) $step_links_id;
                                $step_name_buyer = $buyer_steps->where('id', $step_links_id)->where('step_type', 'Buyer')->first()->title_en;

                                $update_status_all_buyer = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->update(['is_current' => 0, 'is_completed' => 1]);

                                $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->where('title', $step_name_buyer)->orderBy('id', 'desc')->first();
                                
                                if(!$is_exist)
                                {
                                    $is_exist = new OperationsLogs;
                                }
                                $is_exist->operation_id = $operation_id;
                                $is_exist->title = $step_name_buyer;
                                $is_exist->is_current = 1;
                                $is_exist->is_completed = 1;
                                $is_exist->offer_id = $offer_id;
                                $is_exist->log_types = 'Buyer';
                                $is_exist->completed_at = Carbon::now();
                                $is_exist->save();
                            }
                    } 
                }
            } else if($log_type == "Buyer") {
                if($request->has('step_links_ids')) {
                    $seller_steps = $result_deals_tracking['seller_steps'] ?? [];
                        if($step_links_ids && count($step_links_ids) > 0) {
                            foreach($step_links_ids as $step_links_id) {
                                $next_back_seller_ids[]= (int) $step_links_id;
                                $step_name_seller = $seller_steps->where('id', $step_links_id)->where('step_type', 'Seller')->first()->title_en;

                                $update_status_all_buyer = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->update(['is_current' => 0, 'is_completed' => 1]);

                                $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->where('title', $step_name_seller)->orderBy('id', 'desc')->first();
                                
                                if(!$is_exist)
                                {
                                    $is_exist = new OperationsLogs;
                                }
                                $is_exist->operation_id = $operation_id;
                                $is_exist->title = $step_name_seller;
                                $is_exist->is_current = 1;
                                $is_exist->is_completed = 1;
                                $is_exist->offer_id = $offer_id;
                                $is_exist->log_types = 'Seller';
                                $is_exist->completed_at = Carbon::now();
                                $is_exist->save();
                            }
                    } 
                }
            }

            $response = [
                'status' => true,
                'message' => '',
                'data' =>  ['next_title' => app('common')->removeSpecialChars($step_name), 'step' => 'forward' , 'next_back_buyer_ids' => $next_back_buyer_ids, 'next_back_seller_ids' => $next_back_seller_ids],
            ];
        }

        return response()->json($response);
    }

    public function Export(Request $request)
    {
        if ($request->ajax()) 
        {
            try {
               /*  $path = 'export/export_deals'.time().'.xlsx';

                $param = $request->all();

                $result = (new DealsExport($param))->store($path);

                $file_downalod = \Route('secure-file', Crypt::encryptString($path)); */

                $fileName = 'export_deals'.time().'.pdf';

                // $param = $request->only('search', 'operation_type', 'operations_status', 'action');
                $param = $request->all();

                $data = app('deals')->getAll($param, false);
             
                $pdf = Pdf::loadView('admin.exports.pdf.deal-list-pdf', ['data' => $data]);

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

    public function disputeResolve(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required',
            'disputed_id' => 'required',
        ]);

        try {
            $slug = $request->get('offer_id');
            $disputed_id = $request->get('disputed_id');
            $resolved_note = $request->get('resolved_note');
            $offer_result = Offer::where('slug', $slug)->first();
            if(!$offer_result) {
                return redirect()->back()->with('error', __('Record not Found'));
            }
    
            $offer_result->is_disputed = 'No';
            
            $offer_result->save();

            $offer_id = $offer_result->id;
    
            $is_update = DealsDisputes::where('id', $disputed_id)->update(['resolved_note' => $resolved_note, 'resolved_by' => Auth()->user()?->id]);
            return redirect()->back()->with('success', __('Deals updated successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th);
        }
    }

    public function uploadDealsSeog(Request $request, $offer_slug)
    {
        $validated = $request->validate([
            'seog_name' => 'required',
            'seog_file' => 'required|file|mimetypes:application/pdf',
        ]);

        try {
            $slug = $offer_slug;
            $seog_name = $request->get('seog_name');
            $offer_result = Offer::where('slug', $slug)->first();

            if(!$offer_result) {
                return redirect()->back()->with('error', __('Record not Found'));
            }

            if ($request->hasFile('seog_file')) {
                $seog_file = $request->file('seog_file');
                $name = str_replace(' ', '_', $seog_file->getClientOriginalName());
                $size = round($seog_file->getSize() / 1024, 2); //  in KB
                $extension = $seog_file->extension();
                $lastModified = $seog_file->getMTime();
                if ($extension == 'heif') {
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'deals/' . $offer_result->id . '/seog/'.$fileName;

                    $getImageBlob = app('common')->heicToBlob($seog_file->getPathName());
                    Storage::put($path, $getImageBlob);
                }else{                       
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                    $path = $seog_file->storeAs('deals/' . $offer_result->id . '/seog', $fileName);
                }
                

                DealsSeog::create([
                    'offer_id' => $offer_result->id,
                    'seog_name' => $seog_name,
                    'size' => $size,
                    'extension' => $extension,
                    'last_modified' => $lastModified,
                    'path' => $path,
                    'uploaded_by' => Auth()->user()?->id,
                ]);
            }

            return redirect()->back()->with('success', __('Deals SEOG successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th);
        }
    }
    
    public function seogFileDownload(Request $request, $offer_slug)
    {
        ini_set('max_execution_time', 0);
        try {
            $offer_result = Offer::where('slug', $offer_slug)->has('deals_seog')->first();

            if(!$offer_result) {
                return redirect()->back()->with('error', __('Record not found'));
            }

            $param['offer_id'] = $offer_result->id;

            $result_deals = app('deals')->getDetails($param);
            
            $data['deals'] = $result_deals;
        
            $pdf_file_name = time()."_public-seog.pdf";

            /* create pdf */
            $pdf = Pdf::loadView('admin.deals.pdf.seog', $data);

            return $pdf->download($pdf_file_name);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th);
        } 
    }

    public function dealsFlowChangeStatus(Request $request)
    {
        $request->validate([
            'column_name' => 'required|in:is_mipo_commission_payment,is_qr_code_seller,is_cashed_seller,is_cashed_buyer',
            'offer_id' => 'required',
        ]);
        
        $column_name = $request->get('column_name');
        $offer_id = $request->get('offer_id');

        $offer_result = Offer::where('id', $offer_id)->first();
        if(!$offer_result) {
            $response = [
                'status' => false,
                'message' => __('Record not found'),
            ];
            
            return response()->json($response);
        }

        if($column_name == 'is_mipo_commission_payment') {
            $offer_result->is_mipo_commission_payment = ($offer_result->is_mipo_commission_payment == 'Yes') ? 'No' : 'Yes';
        } else if($column_name == 'is_qr_code_seller') {
            $offer_result->is_qr_code_seller =  ($offer_result->is_qr_code_seller == 'Yes') ? 'No' : 'Yes';
        }
        else if($column_name == 'is_cashed_seller') {
            $offer_result->is_cashed_seller =  ($offer_result->is_cashed_seller == 'Yes') ? 'No' : 'Yes';
        }
        else if($column_name == 'is_cashed_buyer') {
            $offer_result->is_cashed_buyer =  ($offer_result->is_cashed_buyer == 'Yes') ? 'No' : 'Yes';
            $offer_result->cashed_date_buyer =  ($offer_result->is_cashed_buyer == 'Yes') ? date('Y-m-d') : null;
            $offer_result->offer_status =  ($offer_result->is_cashed_buyer == 'Yes') ? 'Completed' : 'Approved';
        }
        
        $is_update = $offer_result->save();
        if($is_update) {
            $response = [
                'status' => true,
                'message' => __('Record updated'),
            ];
        } else {
            $response = [
                'status' => false,
                'message' => __('Record not updated'),
            ];
        }
        return response()->json($response);
    }

    public function privateNote(Request $request)
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
            return redirect()->back()->with('success',  __($msg));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th);
        }
    }
}
