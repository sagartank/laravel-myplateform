<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{User, Issuer, IssuerBank};

class CommonController extends Controller
{
    
    public function ajaxSearchUser(Request $request)
    {
        if($request->ajax())
        {
            $all_seller = [];
            $search = $request->get('search');

            if(!empty($search)) {
                $re_param = ($request->all() + ['login_user_id' =>  Auth()->user()->id]);

                $result = User::where('name',  'like', '%' . $re_param['search'] . '%')->whereNot('id', $re_param['login_user_id'] )
                        ->select('id','name')->get();

                if($result->count()) {
                    foreach ($result as $key => $val) {
                        $all_seller[] = [
                            'id' => $val->id,
                            'text' => $val->name,
                        ];
                    }
                }
            }

            $response = [
                'status' => true,
                'message' => '',
                'data' => $all_seller
            ];
            return response()->json($response);
        }
    }

    public function ajaxSearchCompany(Request $request)
    {
        if($request->ajax())
        {
            $all_companies = [];
            $search = $request->get('search');
        
            if(!empty($search)) {
                $re_param = ($request->all() + ['login_user_id' =>  Auth()->user()->id]);

                $result = Issuer::where('first_name',  'like', '%' . $re_param['search'] . '%')
                ->orWhere('company_name',  'like', '%' . $re_param['search'] . '%')
                ->select('id','company_name')->get();

                if($result->count()) {
                    foreach ($result as $key => $val) {
                        $all_companies[] = [
                            'id' => $val->id,
                            'text' => $val->company_name,
                        ];
                    }
                }
            }
            
            $response = [
                'status' => true,
                'message' => '',
                'data' => $all_companies
            ];
            return response()->json($response);
        }
    }

    public function ajaxSearchBank(Request $request)
    {
        if($request->ajax())
        {
            $all_banks = [];
            $search = $request->get('search');

            if(!empty($search)) {
                $re_param = ($request->all() + ['login_user_id' =>  Auth()->user()->id]);

                $result = IssuerBank::where('name',  'like', '%' . $re_param['search'] . '%')
                        ->select('name', 'id')->get();

                if($result->count()) {
                    foreach ($result as $key => $val) {
                        $all_banks[] = [
                            'id' => $val->id,
                            'text' => $val->name,
                        ];
                    }
                }
            }
            
            $response = [
                'status' => true,
                'message' => '',
                'data' => $all_banks
            ];
            return response()->json($response);
        }
    }
}