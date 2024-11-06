<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Offer;
use App\Exports\OfferExport;
use Maatwebsite\Excel\Concerns\FromCollection;

class OffersController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:offer_master|export-offer', ['only' => ['index','show']]);
        $this->middleware('permission:export-offer', ['only' => ['Export']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.offers.index');
    }

    public function ajaxLoadOffersData(Request $request)
    {
        $this->validate($request, [
            'search' => ['nullable', 'string'],
        ]);

        $perPage = $request->input('per_page') ?? config('constants.PER_PAGE_ADMIN');
        $sortType = $request->input('sort_type') ?? 'DESC';
        $sortColumn = $request->input('sort_column') ?? 'id';
        $search = $request->input('search');
        $preferred_currency = $request->input('preferred_currency');
        $offer_status = $request->input('offer_status');

        $req_param['sort_type'] = $sortType;
        $req_param['sort_column'] = $sortColumn;
        $req_param['search'] = $search;
        $req_param['offer_status'] = $offer_status;
        $req_param['preferred_currency'] = $preferred_currency;
        $req_param['per_page'] = $perPage;
    
        $data = app('offer')->getAll($req_param);
        
        return view('admin.offers.ajax.offers-data-table', ['data' => $data, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage]);
    }

    public function Export(Request $request)
    {
        if ($request->ajax()) 
        {
            try {
                $path = 'export/export_offer_'.time().'.xlsx';

                $param = $request->only(['search', 'offer_status', 'preferred_currency']);
                
                $sortType = $request->input('sort_type') ?? 'DESC';
                $sortColumn = $request->input('sort_column') ?? 'id';
                $search = $request->input('search');
                $preferred_currency = $request->input('preferred_currency');
                $offer_status = $request->input('offer_status');

                $req_param['sort_type'] = $sortType;
                $req_param['sort_column'] = $sortColumn;
                $req_param['search'] = $search;
                $req_param['offer_status'] = $offer_status;
                $req_param['preferred_currency'] = $preferred_currency;

                $result = (new OfferExport($req_param))->store($path);

                $file_downalod = \Route('secure-file', \Crypt::encryptString($path));
    
                if($result && $file_downalod)
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
}
