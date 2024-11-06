<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Issuer;
use App\Models\User;
use App\Models\Suggestion;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'suggest_type' => 'required|in:Company,Profile,Other',
            'first_name' => 'required|max:100|min:3',
            'last_name' => 'required|max:100|min:3',
            'email' => 'required|max:100|min:3',
            'phone_number' => 'nullable|max:20',
            'message' => 'required|min:5',
        ],[
            'suggest_type' =>  'invalid suggestions.',
        ]);

        if($request->ajax())
        {
            DB::beginTransaction();
            try {
                $suggest_type = $request->suggest_type;
                $profile_id = $request->profile_id ?? null;
                $company_id = $request->company_id ?? null;
                
                $save = new Suggestion();
                $save->suggest_type = $suggest_type;
                $save->profile_id = $profile_id;
                $save->company_id = $company_id;
                $save->first_name = $request->first_name;
                $save->last_name = $request->last_name;
                $save->email = $request->email;
                $save->phone_number = $request->phone_number;
                $save->message = $request->message;
                $save->save();

                DB::commit();
                
                $response = [
                    'status' => true,
                    'message' => 'successfully',
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
        } else {
            abort(404, 'Page not found!');
        }
    }
}
