<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Offer;
use App\Models\OperationProgress;
use App\Models\OperationsLogs;
use App\Models\DealsTracking;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    
    public function createQrCodeImage()
    {
        $image = QrCode::format('png')
                        ->merge(public_path('blank.png'), 0.5, true)
                        ->size(500)
                        ->errorCorrection('H')
                        ->generate('A simple example of QR code!');

        return response($image)->header('Content-type','image/png');
    }

    public function dealsScaneQrcode($slug, $user_type, $step_id)
    {
        if($slug!='' && $user_type!='' && $step_id!='') {
            // try {
                $offer_result = Offer::where('slug', $slug)->first();
            
                if(!$offer_result) {
                    $response = [
                        'status' => false,
                        'message' =>  __('Qr Scan Record not found.'),
                        'data' => []
                    ];
                    return response()->json($response);
                    // return view('qr-code.qr-code-error', ['message' => "Record not found."]);
                }
                
                $valid = false;
                
                $offer_id = $offer_result->id;

                $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
        
                if($user_type == 'Buyer') {

                    /* deal flow step move */
                    $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
                    $result_first = $all_tracking_steps->where('id', $step_id)->first();
                    $is_qr_code = $result_first->qr_code;

                    if(isset($all_tracking_steps) && $step_id > 0 && $is_qr_code  == 'Yes')
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
                    } else {
                        abort(404, 'Page not found!');
                    }

                     /*qr code status update */
                    $offer_result->is_qr_code_buyer = 'Yes';
                    $offer_result->save();
                    $valid = true;
                } else if($user_type == 'Seller') {

                    /* deal flow step move */
                    $all_tracking_steps = $result_deals_tracking['all_tracking_steps'] ?? [];
                    $result_first = $all_tracking_steps->where('id', $step_id)->first();
                    $is_qr_code = $result_first->qr_code;

                    if(isset($all_tracking_steps) && $step_id > 0 && $is_qr_code == 'Yes')
                    {

                        OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->update(['is_current' => 0, 'is_completed' => 1]);
                        
                        OperationsLogs::operationsAddLogs(5, '0', 'Seller', $offer_id);
                        
                        OperationsLogs::operationsAddLogs(6, '1', 'Seller', $offer_id);

                        OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->update(['is_current' => 0, 'is_completed' => 1]);

                        OperationsLogs::operationsAddLogs(7, '0', 'Buyer', $offer_id);
                        
                        /*  $step_data_first =  $all_tracking_steps->where('id', $step_id)->first();
        
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
                        } */
                    } else {
                        abort(404, 'Page not found!');
                    }

                    /*qr code status update */
                    $offer_result->is_qr_code_seller = 'Yes';
                    $offer_result->save();
                    $valid = true;
                }
                if($valid) {
                    $response = [
                        'status' => true,
                        'message' =>  __('Qr code Scan successfully.'),
                        'data' => []
                    ];
                    return response()->json($response);
                    // return view('qr-code.qr-code-success', ['message' => "Qr code Scan successfully."]);
                }
            /*  } catch (\Throwable $th) {
                return view('qr-code.qr-code-error', ['message' =>  $th->getMessage() .' Line No  :'. $th->getLine()]);
            } */
        } else {
            $response = [
                'status' => false,
                'message' =>  __('Qr Scan Record not found.'),
                'data' => []
            ];
            return response()->json($response);
            // return view('qr-code.qr-code-error', ['message' => "Record not found."]);
        }
    }

    public function dealsScaneQrcode_old_working($slug, $user_type, $step_id)
    {
        if($slug!='' && $user_type!='' && $step_id!='') {
            try {
                $offer_result = Offer::where('slug', $slug)->first();
            
                if(!$offer_result) {
                /*  $response = [
                        'status' => false,
                        'message' => 'Record not found.',
                        'data' => []
                    ];
                    return response()->json($response); */
                    return view('qr-code.qr-code-error', ['message' => "Record not found."]);
                }
                $valid = false;
                $offer_id = $offer_result->id;

                $result_deals_tracking = app('deals_tracking')->getOperationByTracking($offer_id);
        
                if($user_type == 'Buyer') {

                    /* deal flow step move */
                    $seller_steps = $result_deals_tracking['seller_steps'] ?? [];
                    $buyer_steps = $result_deals_tracking['buyer_steps'] ?? [];
                    if(isset($seller_steps) && isset($buyer_steps) &&  $step_id > 0)
                    {
                        $buyer_step_data =  $seller_steps->where('id', $step_id)->where('step_type', 'Buyer')->first();
                        $step_name_buyer = $buyer_step_data->title_en;
        
                        $step_links_ids = [];
                        if(isset($buyer_step_data->step_links) && !is_null($buyer_step_data->step_links) && !empty($buyer_step_data->step_links))
                        {
                            $step_links_ids = json_decode($buyer_step_data->step_links);
                        }
                
                        if($step_links_ids && count($step_links_ids) > 0)
                        {
                            foreach($step_links_ids as $step_links_id) 
                            {

                                $next_back_buyer_ids[]= (int) $step_links_id;

                                $step_name_seller = $buyer_steps->where('id', $step_links_id)->where('step_type', 'Seller')->first()->title_en;

                                $update_status_all_seller = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->update(['is_current' => 0, 'is_completed' => 1]);

                                $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Seller')->where('title', $step_name_seller)->orderBy('id', 'desc')->first();
                                
                                if(!$is_exist)
                                {
                                    $is_exist = new OperationsLogs;
                                }
                                $is_exist->operation_id = null;
                                $is_exist->title = $step_name_seller;
                                $is_exist->is_current = 1;
                                $is_exist->is_completed = 1;
                                $is_exist->offer_id = $offer_id;
                                $is_exist->log_types = 'Seller';
                                $is_exist->user_ip_address = \Request::userAgent();
                                $is_exist->user_device = \Request::ip();
                                $is_exist->completed_at = Carbon::now();
                                $is_exist->save();
                            }
                        }
                    }

                     /*qr code status update */
                    $offer_result->is_qr_code_buyer = 'Yes';
                    $offer_result->save();
                    $valid = true;
                } else if($user_type == 'Seller') {

                    /* deal flow step move */
                    $seller_steps = $result_deals_tracking['seller_steps'] ?? [];
                    $buyer_steps = $result_deals_tracking['buyer_steps'] ?? [];
                    if(isset($seller_steps) && isset($buyer_steps) &&  $step_id > 0)
                    {
                        $seller_step_data =  $seller_steps->where('id', $step_id)->where('step_type', 'Seller')->first();
                        $step_name_seller = $seller_step_data->title_en;
            
                        $step_links_ids = [];
                        if(isset($seller_step_data->step_links) && !is_null($seller_step_data->step_links) && !empty($seller_step_data->step_links))
                        {
                            $step_links_ids = json_decode($seller_step_data->step_links);
                        }
                
                        if($step_links_ids && count($step_links_ids) > 0)
                        {
                            foreach($step_links_ids as $step_links_id) 
                            {

                                $next_back_buyer_ids[]= (int) $step_links_id;

                                $step_name_buyer = $buyer_steps->where('id', $step_links_id)->where('step_type', 'Buyer')->first()->title_en;

                                $update_status_all_buyer = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->update(['is_current' => 0, 'is_completed' => 1]);

                                $is_exist = OperationsLogs::where('offer_id', $offer_id)->where('log_types', 'Buyer')->where('title', $step_name_buyer)->orderBy('id', 'desc')->first();
                                
                                if(!$is_exist)
                                {
                                    $is_exist = new OperationsLogs;
                                }
                                $is_exist->operation_id = null;
                                $is_exist->title = $step_name_buyer;
                                $is_exist->is_current = 1;
                                $is_exist->is_completed = 1;
                                $is_exist->offer_id = $offer_id;
                                $is_exist->log_types = 'Buyer';
                                $is_exist->user_ip_address = \Request::userAgent();
                                $is_exist->user_device = \Request::ip();
                                $is_exist->completed_at = Carbon::now();
                                $is_exist->save();
                            }
                        }
                    } 

                    /*qr code status update */
                    $offer_result->is_qr_code_seller = 'Yes';
                    $offer_result->save();
                    $valid = true;
                }
                if($valid) {
                    return view('qr-code.qr-code-success', ['message' => "Qr code Scan successfully."]);
                    /*  $response = [
                        'status' => true,
                        'message' => 'Scan QR codes successfully.',
                        'data' => []
                    ]; */
                }
            } catch (\Throwable $th) {
                return view('qr-code.qr-code-error', ['message' =>  $th->getMessage() .' Line No  :'. $th->getLine()]);
                /*  $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ]; */
            }
        } else {
            return view('qr-code.qr-code-error', ['message' => "Record not found."]);
          /*   $response = [
                'status' => false,
                'message' => 'Record not found.',
                'data' => []
            ]; */
        }
        // return response()->json($response);
    }
}
