<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserContractSing;
use App\Models\User;

class UserContractSingController extends Controller
{   
    public function index(Request $request)
    {   
        try {
            $issuer_id =  $request->get('issuer_id');

            $company_owner_name = User::where('issuer_id', $issuer_id)->where('parent_id', '>', 0)->with('parentUser:id,name')->first()?->parentUser?->name;
        
            $result = UserContractSing::with(['user'])->where('issuer_id', $issuer_id)->orderBy('id', 'desc')->get();
    
            $dhtml = view('admin.payer-issuer.ajax.user-contract-sign-table', ['data' => $result, 'company_owner_name'  => $company_owner_name])->render();

            $response = [
                'status' => true,
                'data' => ['dhtml' => $dhtml],
                'message' => 'success',
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'issuer_id' => 'required',
            'user_id' => 'required',
            // 'name' => 'required',
            // 'email' => 'required|email',
            // 'mobile_number' => 'nullable|regex:/^([0-9\ \-\+\(\)]*)$/',
        ]);

        try {
            $user = User::where('slug',$request->input('user_id'))->first();
            if($request->has('edit_id') && $request->get('edit_id') > 0) 
            {
                UserContractSing::where('id', $request->get('edit_id'))
                        ->update([
                        'issuer_id' => $request->input('issuer_id'),
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'mobile_number' => $user->phone_number,
                    ]);
        
                $response = [
                    'status' => true,
                    'message' => 'Updated successfully.',
                    'data' => []
                ];
            } else {
                UserContractSing::create([
                    'issuer_id' => $request->input('issuer_id'),
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile_number' => $user->phone_number,
                ]);
    
                $response = [
                    'status' => true,
                    'message' => 'Added successfully.',
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
    }

    public function delete(Request $request, $id)
    {
        UserContractSing::where('id', $id)->forceDelete();
        
        $response = [
            'status' => true,
            'message' => 'Deleted successfully.',
            'data' => []
        ];
        return response()->json($response);
    }
}
