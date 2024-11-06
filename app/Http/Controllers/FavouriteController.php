<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Issuer;
use App\Models\User;
use App\Models\Favorite;

class FavouriteController extends Controller
{
    public function store(Request $request)
    {

        if ($request->ajax())
        {
            $this->validate($request, [
                'type' => ['required', 'in:user,issuer'],
            ],[
                'type' =>  'something went wrong. please try again',
            ]);

            DB::beginTransaction();
            try {
                $status = true;
                $type = $request->type;
                if(isset($type) && $type == 'issuer') {
                    $issuer_id = $request->issuer_id;
                    $user_login_id = Auth()->user()?->id;
                    
                    $issuer = Issuer::select('id', 'company_name')->where('id', $issuer_id)->first();
                    
                    if($issuer && $issuer_id > 0) 
                    {
                        $is_favorites = Favorite::where(['favoriteable_id' => $issuer_id, 'user_id' => $user_login_id, 'favoriteable_type' => get_class($issuer)])->first();
                        if($is_favorites) {
                            $is_favorites->delete();
                            $msg =  'Unfavourite';
                        } else {
                            $save = new Favorite();
                        $save->favoriteable_type = get_class($issuer);
                        $save->favoriteable_id = $issuer_id;
                        $save->save();
                        $msg =  'Favourite';
                        }
                    } 
                } else if(isset($type) && $type == 'user') {
                    $user_id = $request->user_id;
                    $user_login_id = Auth()->user()?->id;
                    
                    $user = User::select('id', 'name')->where('id', $user_id)->first();
                    
                    if($user && $user_id > 0) 
                    {
                        $is_favorites = Favorite::where(['favoriteable_id' => $user_id, 'user_id' => $user_login_id, 'favoriteable_type' => get_class($user)])->first();
                        if($is_favorites) {
                            $is_favorites->delete();
                            $msg =  'Unfavourite';
                        } else {
                            $save = new Favorite();
                        $save->favoriteable_type = get_class($user);
                        $save->favoriteable_id = $user_id;
                        $save->save();
                        $msg =  'Favourite';
                        }
                    } 
                } else {
                    $msg ="something went wrong. please try again";
                    $status = false;
                }
                DB::commit();
                $response = [
                    'status' => $status,
                    'message' => $msg,
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
