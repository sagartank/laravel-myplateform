<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;
use App\Models\Operation;
use App\Models\OperationProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $param = array();
        $data['user_id'] =  Auth()->user()->id;
        $data['user_level_name'] =  Auth()->user()->user_level;
        $data['preferred_dashboard'] = config('constants.PREFERRED_DASHBOARD_Arr');
        $data['currency_type'] = config('constants.CURRENCY_TYPE');
        $data['currency_symbols'] = config('constants.CURRENCY_SYMBOLS');
        $data['duration_months'] = config('constants.DURATION_MONTHS');
        $data['current_date_month'] = date('01/m/Y');
        $data['current_end_date_month'] = date('t/m/Y');

        if(Auth()->user()->preferred_language!='') {
            App::setLocale(Auth()->user()->preferred_language);
            session()->put('locale', Auth()->user()->preferred_language);
        } else {
            App::setLocale('es');
            session()->put('locale', 'es');
        }

        return view('dashboard', $data);
    }

    public function ajaxDashboard(Request $request)
    {
        $request->validate([
            'preferred_dashboard' => 'required|in:Borrower,Investor',
        ]);

        try {
            $preferred_dashboard = $request->get('preferred_dashboard');

            $param = $response_data = array();
            $barchart_borrower_data = $barchart_investor_data  = [];
    
            $param['page_name'] = 'dashboard';
            $param['user_id'] = Auth()->user()->id;
            $param['currency_type'] = $request->get('currency_type');
            $param['sort_type_deals'] = $request->get('sort_type_deals', 'DESC');
            $param['duration_months'] = $request->get('duration_months');
            $param['preferred_dashboard'] = $preferred_dashboard;
            $param['user_account_type'] = Auth()->user()->account_type;
            $param['current_date'] = date('Y-m-d');
            
            if($request->has('duration_date_range')) {
                $arr_duration_date_range = explode('-', $request->get('duration_date_range'));
                $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
                $param['start_date'] = $response_date['start_date'];
                $param['end_date'] = $response_date['end_date'];
                $param['last_month_start'] =  Carbon::createFromFormat('Y-m-d',  $param['start_date'])->subMonth()->format('Y-m-01');
                $param['last_month_end'] = Carbon::createFromFormat('Y-m-d',  $param['last_month_start'])->format('Y-m-31');
                $param['duration_date_range'] = $param['start_date'].'&'.$param['end_date'];
                $param['offer_status_all'] = false;
            }
        
            $dashboard_deals = app('dashboard')->getDashboarDeals($param);
        
            $dashboard_deals_last_month = app('dashboard')->getDashboarDealsLastMonth($param);
            
            $pichart_data = app('dashboard')->getPichartData($param);
    
            $barchart_result = app('dashboard')->getBarchartData($param);
    
            if($preferred_dashboard == 'Borrower') {
                if($barchart_result) {
                    foreach ($barchart_result->groupBy('month_year') as $month_year_key => $val) {
                        $barchart_borrower_data[$barchart_result->where('month_year', $month_year_key)->first()->month_name] = $barchart_result->where('month_year', $month_year_key)->sum('amount');
                    }
                    $response_data[strtolower($preferred_dashboard)]['finalized_deals'] = $barchart_borrower_data;
                    $response_data[strtolower($preferred_dashboard)]['deals_in_progress'] = $barchart_borrower_data;
                }
                $response_data['first_section'] = view('dashboard.borrower.first-section', ['borrower_deals' => $dashboard_deals,'dashboard_deals_last_month' => $dashboard_deals_last_month,'req_param' => $param])->render();
            } else if($preferred_dashboard == 'Investor') {
                if($barchart_result) {
                    foreach ($barchart_result->groupBy('month_year') as $month_year_key => $val) {
                        $barchart_borrower_data[$barchart_result->where('month_year', $month_year_key)->first()->month_name] = $barchart_result->where('month_year', $month_year_key)->sum('amount');
                    }
                    $response_data[strtolower($preferred_dashboard)]['incomes'] = $barchart_borrower_data;
                    $response_data[strtolower($preferred_dashboard)]['deals_in_progress'] = $barchart_borrower_data;
                }
                $response_data['first_section'] = view('dashboard.investor.first-section', ['investor_deals' => $dashboard_deals,'dashboard_deals_last_month' => $dashboard_deals_last_month,'req_param' => $param ])->render();
            }
            
            $response_data['second_section'] = view('dashboard.common.latest-update-in-deals', ['update_deals' => $dashboard_deals->whereIn('offer_status', ['Approved', 'Completed']), 'req_param' => $param ])->render();
    
            $last_section['req_param'] = $param;
            
    
            if($param['user_account_type'] == 'Enterprise' && ($param['preferred_dashboard'] == 'Borrower' || $param['preferred_dashboard'] == 'Investor'))
            {
                /*query for account enterprise */
                $param['offer_status_all'] = true;
                
                $seven_days = now()->addDays(7)->format('Y-m-d');
                $fifteen_days = now()->addDays(15)->format('Y-m-d');
                $thirteen_days = now()->addDays(30)->format('Y-m-d');

                $get_due_data = app('dashboard')->getDueDashboarDeals($param);
    
                $last_section['due_seven_days'] =  $get_due_data->where('expires_at', '<=', $seven_days);
                $last_section['due_fifteen_days'] = $get_due_data->where('expires_at', '>', $seven_days)->where('expires_at', '<=', $fifteen_days);
                $last_section['due_thirty_days'] = $get_due_data->where('expires_at', '>', $fifteen_days)->where('expires_at', '<=', $thirteen_days);
                $last_section['exp_thirty_days'] = $get_due_data->where('expires_at', '>', $thirteen_days);
                
                $important_data_seller_enterpirse = app('dashboard')->getDashboarDeals($param);
                $average_rating_days = app('dashboard')->averageRatingDays($param);
    
                $last_section['important_data_deals'] = $important_data_seller_enterpirse;
                $last_section['average_rating_days'] = $average_rating_days;
                if($param['preferred_dashboard'] == 'Borrower') {
                    $last_section['enterprises_data'] = app('dashboard')->getDashboarEnterprise($param);
                } else if($param['preferred_dashboard'] == 'Investor') {
                    $last_section['investor_data'] = app('dashboard')->getDashboarEnterprise($param);
                    $last_section['micoins_point'] = app('dashboard')->getDashboardMiCoinsPoint($param);
                }

                $last_section['best_seller_name'] = app('dashboard')->getDashboarBestSeller($param);
                $last_section['open_disputes'] = $dashboard_deals;

                  /* line chart */
                $dashboard_line_charts = app('dashboard')->getDashboarLineChart($param);
                $last_section['line_chart_offers_data'] = $dashboard_line_charts->pluck('amount')->toArray();
                $last_section['line_chart_operation_data'] = $dashboard_line_charts->pluck('operations')->flatten()->pluck('amount')->toArray();
                $last_section['line_chart_lable'] = $dashboard_line_charts->pluck('operations')->flatten()->pluck('operation_number')->toArray();
                $last_section['dashboard_line_chart_table'] = $dashboard_line_charts;

                $response_data['last_section'] = view('dashboard.common.sub-user-roi-and-important', $last_section)->render();
            } 

            $response_data['pichart'] = $pichart_data;
            $response_data['preferred_dashboard'] = strtolower($preferred_dashboard);
            
            User::where('id', Auth()->user()->id)->update([
                'preferred_dashboard' => trim($request->get('preferred_dashboard')),
                'preferred_currency' => trim($request->get('currency_type'))
            ]);
            
            $response = [
                'status' => true,
                'message' => __('Dashboard succesfully.'),
                'data' => [$response_data]
            ];

        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                'data' => []
            ];
        }
        return response()->json($response);
    }

    /* dashboard borrower */
    public function finalizedDealsDetails(Request $request, $date_range, $currency_type)
    {
        if(empty($date_range) || !in_array($currency_type, $this->only_request_currency)) {
            abort(404, 'Page not found!');
        }

        $param = array();
        $arr_duration_date_range = explode('&', $date_range);

        $param['start_date'] = Carbon::parse($arr_duration_date_range[0])->format('d/m/Y');
        $param['end_date'] = Carbon::parse($arr_duration_date_range[1])->format('d/m/Y');
        $param['date_range'] = $param['start_date'].' - '.$param['end_date'];
        $param['currency_type'] = $currency_type;
        $param['user_id'] = Auth()->user()->id;

        return view('dashboard.borrower.finalized-deals', $param);
    }

    public function ajaxFinalizedDealsDetails(Request $request)
    {
        if ($request->ajax()) {
            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $custome_param['preferred_dashboard'] = 'Borrower';
            $custome_param['user_account_type'] = Auth()->user()->account_type;
            $custome_param['currency_type'] = $request->get('currency_type', 'USD');
            $custome_param['action'] = $request->get('action');

            if($request->has('duration_date_range')) {
                $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
                $custome_param['start_date'] = $response_date['start_date'];
                $custome_param['end_date'] = $response_date['end_date'];
            }

            $param = ($request->all() + $custome_param);

            $dashboard_deals = app('dashboard')->getDashboarDeals($param);


           $treemap_data = [
                [
                    'what' => 'Cheque',
                    'value' => $dashboard_deals->pluck('operations')->flatten()->where('operation_type', 'Cheque')->sum('amount'),
                    'color' => '#265EB0',
                ],
                [
                    'what' => 'Invoice',
                    'value' => $dashboard_deals->pluck('operations')->flatten()->where('operation_type', 'Invoice')->sum('amount'),
                    'color' => '#4689EC',
                ],
                [
                    'what' => 'Contract',
                    'value' => $dashboard_deals->pluck('operations')->flatten()->where('operation_type', 'Contract')->sum('amount'),
                    'color' => '#2F6DC9',
                ],
                [
                    'what' => 'Other',
                    'value' => $dashboard_deals->pluck('operations')->flatten()->where('operation_type', 'Other')->sum('amount'),
                    'color' => '#72A6F3',
                ]
                ];

            if($custome_param['action'] == 'pdf') {
                $data['borrower_deals'] = $dashboard_deals;
                $data['req_param'] = $param;
                
                $file_path = "/dashboard/borrower/finalized-deals/pdf/";

                $pdf_file_name = time()."-borrower-finalized-deals.pdf";

                if($custome_param['action'] == 'pdf_old_working') {
                    /* create pie chart image */
                    $canvas_image = $request->get('pie_chart_image');  // your base64 encoded
                    $canvas_image = str_replace('data:image/png;base64,', '', $canvas_image);
                    $canvas_image = str_replace(' ', '+', $canvas_image);
                    $canvas_image_name = time().'.'.'png';
                    
                    Storage::put($file_path.$canvas_image_name, base64_decode($canvas_image));
                    

                    $data['pie_chart_image'] = storage_path('app/'.$file_path.$canvas_image_name);

                    /* create pdf */
                    $pdf = Pdf::loadView('dashboard.borrower.pdf.finalized-deals', $data);
                }
                
                $pdf = Pdf::loadView('dashboard.borrower.pdf.sold-documents', $data);
                
                $file_full_path = storage_path('app'.$file_path.$pdf_file_name);
                
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
                
                $content = $pdf->download()->getOriginalContent();

                Storage::put($file_path.$pdf_file_name, $content);

                 /* delete pie chart image */
                @unlink($data['pie_chart_image']);

                return response()->download($file_full_path, $pdf_file_name, $headers)->deleteFileAfterSend(true);;
            }

            $dhtml = view('dashboard.borrower.ajax.ajax-finalized-deals', ['borrower_deals' => $dashboard_deals, 'req_param' => $param ])->render();
            
            $response = [
                'status' => true,
                'message' => __('Dashboard succesfully.'),
                'data' => ['dhtml' => $dhtml, 'treemap_data' => $treemap_data]
            ];
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function finalizedOperationsDetails(Request $request, $date_range, $currency_type)
    {
        if(empty($date_range) || !in_array($currency_type, $this->only_request_currency)) {
            abort(404, 'Page not found!');
        }

        $param = array();
        $arr_duration_date_range = explode('&', $date_range);

        $param['start_date'] = Carbon::parse($arr_duration_date_range[0])->format('d/m/Y');
        $param['end_date'] = Carbon::parse($arr_duration_date_range[1])->format('d/m/Y');
        $param['date_range'] = $param['start_date'].' - '.$param['end_date'];
        $param['currency_type'] = $currency_type;
        $param['user_id'] = Auth()->user()->id;

        return view('dashboard.borrower.finalized-operations', $param);
    }

    public function ajaxFinalizedOperationsDetails(Request $request)
    {
        if ($request->ajax()) {
            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $custome_param['preferred_dashboard'] = 'Borrower';
            $custome_param['user_account_type'] = Auth()->user()->account_type;
            $custome_param['currency_type'] = $request->get('currency_type', 'USD');
            $custome_param['action'] = $request->get('action');
            if($request->has('duration_date_range')) {
                $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
                $custome_param['start_date'] = $response_date['start_date'];
                $custome_param['end_date'] = $response_date['end_date'];
            }
            $param = ($request->all() + $custome_param);
            $dashboard_deals = app('dashboard')->getDashboarDeals($param);

            $dashboard_line_charts = app('dashboard')->getDashboarLineChart($param);

            $line_chart_data['line_chart_offers_data'] = $dashboard_line_charts->pluck('amount')->toArray();
            $line_chart_data['line_chart_operation_data'] = $dashboard_line_charts->pluck('operations')->flatten()->pluck('amount')->toArray();
            $line_chart_data['line_chart_lable'] = $dashboard_line_charts->pluck('operations')->flatten()->pluck('operation_number')->toArray();
            
            if($custome_param['action'] == 'pdf') {
                $data['borrower_deals'] = $dashboard_deals;
                $data['dashboard_line_chart_table'] = $dashboard_line_charts;
                $data['req_param'] = $param;
                
                $file_path = "/dashboard/borrower/finalized-operations/pdf/";
                $pdf_file_name = time()."-borrower-finalized-operations.pdf";
                
                if($custome_param['action'] == 'pdf_old_working') {
                    /* create pie chart image */
                    $canvas_image = $request->get('line_chart_image');  // your base64 encoded
                    $canvas_image = str_replace('data:image/png;base64,', '', $canvas_image);
                    $canvas_image = str_replace(' ', '+', $canvas_image);
                    $canvas_image_name = time().'.'.'png';
                    
                    Storage::put($file_path.$canvas_image_name, base64_decode($canvas_image));

                    $data['line_chart_image'] = storage_path('app/'.$file_path.$canvas_image_name);
                }

                /* create pdf */
                // $pdf = Pdf::loadView('dashboard.borrower.pdf.finalized-operations', $data);
                
                $pdf = Pdf::loadView('dashboard.borrower.pdf.finalized-deals-pdf', $data);

                $file_full_path = storage_path('app'.$file_path.$pdf_file_name);
                
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
                
                $content = $pdf->download()->getOriginalContent();

                Storage::put($file_path.$pdf_file_name, $content);

                 /* delete pie chart image */
                @unlink($data['line_chart_image']);

                return response()->download($file_full_path, $pdf_file_name, $headers)->deleteFileAfterSend(true);;
            }


            $dhtml = view('dashboard.borrower.ajax.ajax-finalized-operations', ['borrower_deals' => $dashboard_deals, 'req_param' => $param, 'dashboard_line_chart_table' => $dashboard_line_charts], $line_chart_data)->render();
            
            $response = [
                'status' => true,
                'message' => __('Dashboard succesfully.'),
                'data' => ['dhtml' => $dhtml]
            ];
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    /* dashboard investor */
    public function incomesProiftLossDetails(Request $request, $date_range, $currency_type)
    {
        if(empty($date_range) || !in_array($currency_type, $this->only_request_currency)) {
            abort(404, 'Page not found!');
        }
        
        $param = array();
        $arr_duration_date_range = explode('&', $date_range);

        $param['start_date'] = Carbon::parse($arr_duration_date_range[0])->format('d/m/Y');
        $param['end_date'] = Carbon::parse($arr_duration_date_range[1])->format('d/m/Y');
        $param['date_range'] = $param['start_date'].' - '.$param['end_date'];
        $param['currency_type'] = $currency_type;
        $param['user_id'] = Auth()->user()->id;

        return view('dashboard.investor.incomes-profit-loss', $param);
    }

    public function ajaxIncomesProiftLossDetails(Request $request)
    {
        if ($request->ajax()) {
            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $custome_param['preferred_dashboard'] = 'Investor';
            $custome_param['user_account_type'] = Auth()->user()->account_type;
            $custome_param['currency_type'] = $request->get('currency_type', 'USD');
            $custome_param['action'] = $request->get('action');
            if($request->has('duration_date_range')) {
                $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
                $custome_param['start_date'] = $response_date['start_date'];
                $custome_param['end_date'] = $response_date['end_date'];
            }
            
            $param = ($request->all() + $custome_param);
            $dashboard_deals = app('dashboard')->getDashboarDeals($param);
            
            if($custome_param['action'] == 'pdf') {
                $data['investor_deals'] = $dashboard_deals;
                $data['req_param'] = $param;
                
                $file_path = "/dashboard/investor/pdf/";

                $pdf_file_name = time()."-incomes-investore.pdf";
                
                /*old desing 0.1 */
                if($custome_param['action'] == 'pdf_old_working') {
                    /* create pie chart image */
                    $canvas_image = $request->get('pie_chart_image');  // your base64 encoded
                    $canvas_image = str_replace('data:image/png;base64,', '', $canvas_image);
                    $canvas_image = str_replace(' ', '+', $canvas_image);
                    $canvas_image_name = time().'.'.'png';
                    
                    Storage::put($file_path.$canvas_image_name, base64_decode($canvas_image));

                    $data['pie_chart_image'] = storage_path('app/'.$file_path.$canvas_image_name);
                    /* create pdf */
                    $pdf = Pdf::loadView('dashboard.investor.pdf.incomes-profit-loss', $data);
                }
                
                /* new desing 1.2 */
                $pdf = Pdf::loadView('dashboard.investor.pdf.total-investment', $data);

                $file_full_path = storage_path('app'.$file_path.$pdf_file_name);
                
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
                
                $content = $pdf->download()->getOriginalContent();

                Storage::put($file_path.$pdf_file_name, $content);

                 /* delete pie chart image */
                // @unlink($data['pie_chart_image']);

                return response()->download($file_full_path, $pdf_file_name, $headers)->deleteFileAfterSend(true);;
            }

            $dhtml = view('dashboard.investor.ajax.ajax-incomes-profit-loss', ['investor_deals' => $dashboard_deals, 'req_param' => $param ])->render();
            
            $response = [
                'status' => true,
                'message' => __('Dashboard succesfully.'),
                'data' => ['dhtml' => $dhtml]
            ];
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function riskManagmentDetails(Request $request, $date_range, $currency_type)
    {
        if(empty($date_range) || !in_array($currency_type, $this->only_request_currency)) {
            abort(404, 'Page not found!');
        }

        $param = array();
        $arr_duration_date_range = explode('&', $date_range);

        $param['start_date'] = Carbon::parse($arr_duration_date_range[0])->format('d/m/Y');
        $param['end_date'] = Carbon::parse($arr_duration_date_range[1])->format('d/m/Y');
        $param['date_range'] = $param['start_date'].' - '.$param['end_date'];
        $param['currency_type'] = $currency_type;
        $param['user_id'] = Auth()->user()->id;

        return view('dashboard.investor.risk-managment', $param);
    }

    public function ajaxRiskManagmentDetails(Request $request)
    {
        if ($request->ajax()) {
            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
            $custome_param['preferred_dashboard'] = 'Investor';
            $custome_param['user_account_type'] = Auth()->user()->account_type;
            $custome_param['currency_type'] = $request->get('currency_type', 'USD');
            $custome_param['action'] = $request->get('action');
            
            if($request->has('duration_date_range')) {
                $response_date = app('common')->dateRangeExplode($request->get('duration_date_range'), '-');
                $custome_param['start_date'] = $response_date['start_date'];
                $custome_param['end_date'] = $response_date['end_date'];
            }
            $param = ($request->all() + $custome_param);
            $dashboard_deals = app('dashboard')->getDashboarDeals($param);

            if($custome_param['action'] == 'pdf') {
                $data['investor_deals'] = $dashboard_deals;
                $data['req_param'] = $param;
                
                $file_path = "/dashboard/investor/pdf/";
                $pdf_file_name = time()."-risk-managment-investore.pdf";

                 /*old desing 0.1 */
                if($custome_param['action'] == 'pdf_old_working') {
                    /* create pie chart image */
                    $canvas_image = $request->get('pie_chart_image');  // your base64 encoded
                    $canvas_image = str_replace('data:image/png;base64,', '', $canvas_image);
                    $canvas_image = str_replace(' ', '+', $canvas_image);
                    $canvas_image_name = time().'-risk-managment-investore-image.'.'png';
                    
                    Storage::put($file_path.$canvas_image_name, base64_decode($canvas_image));

                    $data['pie_chart_image'] = storage_path('app/'.$file_path.$canvas_image_name);

                    /* create pdf */
                    $pdf = Pdf::loadView('dashboard.investor.pdf.risk-managment', $data);
                }

                $pdf = Pdf::loadView('dashboard.investor.pdf.guaranteed-repurchase', $data);

                $file_full_path = storage_path('app'.$file_path.$pdf_file_name);
                
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
                
                $content = $pdf->download()->getOriginalContent();

                Storage::put($file_path.$pdf_file_name, $content);

                 /* delete pie chart image */
                @unlink($data['pie_chart_image']);

                return response()->download($file_full_path, $pdf_file_name, $headers)->deleteFileAfterSend(true);;
            }

            $dhtml = view('dashboard.investor.ajax.ajax-risk-managment', ['investor_deals' => $dashboard_deals, 'req_param' => $param ])->render();
            
            $response = [
                'status' => true,
                'message' => __('Dashboard succesfully.'),
                'data' => ['dhtml' => $dhtml]
            ];
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
}
