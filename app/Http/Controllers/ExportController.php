<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exploreOperationDetail(Request $request, $slug)
    {
        // try {
            // ini_set('max_execution_time', 0);
            set_time_limit(300); 
            // return view('pdf.operation-detail');

            // Record the start time
            $startTime = microtime(true);

            $currency_symblos = config('constants.CURRENCY_SYMBOLS');
    
            $result = app('operation')->getOperationById($operation_id = null, $slug);

            if($result)
            {
                $data['operation'] = $result;
                
                $data['currency_symblos'] = $currency_symblos;
                $data['imageUrl'] = asset('images/mipo/pdf/singlestr48.png');
        
                $fileName = $result->operation_number.".pdf";

                $pdf = Pdf::loadView('pdf.web-explore-operation-detail', $data);
                
                $endTime = microtime(true);

                // Calculate the load time
                $loadTime = $endTime - $startTime;
        
                // Log or display the load time
                \Log::info("PDF Load Time: {$loadTime} seconds");

                // return $pdf->stream();
                return $pdf->download($fileName);
                
            } else {
                return redirect()->route('explore-operations.index')->with('error', 'something went wrong');
                /* $response = [
                    'status' => false,
                    'message' => 'No file Downalod',
                    'data' => ''
                ]; */
            }
        // } catch (\Throwable $th) {
        //     return redirect()->route('explore-operations.index')->with('error', $th->getMessage() .'Line No. ' . $th->getLine());
        // }
    }
}
