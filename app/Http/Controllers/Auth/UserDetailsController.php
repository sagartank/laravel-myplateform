<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SignUp as  NotificationAdminSignUp;
use App\Models\UserCompany;
use App\Models\City;
use App\Models\Issuer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterApprovalNonApprovalWaiting;

class UserDetailsController extends Controller
{
    public function create(Request $request)
    {
        // if($request->user() && $request->user()->is_registration_complete){
        //     return redirect('/');
        // }
        return view('auth.user-details', [
            // 'countries' => DB::table('countries')->select('id', 'name')->get(),
            'cities' => City::getAllCities(),
        ]);
    }

    public function store(Request $request)
    {  
        $img_mimes = config('constants.PROFILE_IMAGE_MIMES');
        $img_mb = config('constants.PROFILE_IMAGE_MAX_MB');
        $img_dim = config('constants.PROFILE_IMAGE_DIMENSIONS');
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');

        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before:- 18 years'],
            'marital_status' => ['required', 'string'],
            'profile_image' => 'nullable|'.$img_mimes,
            'address' => ['required', 'string'],
            'city_id' => ['required'],
            'ruc_tax_id' => ['required', 'string', 'max:100'],
            // 'ruc_tax_id' => ['required', 'string', 'max:100','unique:issuers,ruc_text_id'],
            // 'attach_company_documents' => ['nullable', 'file', 'mimetypes:image/*,application/pdf'],
        ],
        ['ruc_tax_id.unique' => __('The RUC has already been taken.')]
    );
    
        DB::beginTransaction();
        try {
            //store issuer data in issuer table
            $payer_issuer = Issuer::where('ruc_text_id', trim($request->input('ruc_tax_id')))->first();
            if(is_null($payer_issuer)){
                $payer_issuer = new Issuer;
                $payer_issuer->first_name = $request->input('first_name') ?? null;
                $payer_issuer->last_name = $request->input('last_name') ?? null;
                $payer_issuer->company_name = $request->input('first_name') ." ".$request->input('last_name') ;
                $payer_issuer->marital_status = $request->input('marital_status');
                $payer_issuer->ruc_text_id =  $request->input('ruc_tax_id');
                $payer_issuer->ruc_code_optional = $request->input('ruc_code');
                $payer_issuer->address = $request->input('address');
                $payer_issuer->city_id = $request->input('city_id');
                $payer_issuer->registered_at = date('Y-m-d');
            }
            $payer_issuer->save();
            

            $user = Auth()->user();

            $user->first_name = $request->input('first_name') ?? null;
            $user->last_name = $request->input('last_name') ?? null;
            $user->name = $user->first_name . " " . $user->last_name;
            $user->birth_date = Carbon::parse($request->input('birth_date'))->format('Y-m-d');
            //$user->gender = $request->input('gender');
            $user->marital_status = $request->input('marital_status');
            $user->country_id = null;
            // $user->country_id = $request->input('country_id');
            // $user->state = $request->input('state');
            $user->state = null;
            $user->address = $request->input('address');
            $user->city_id = $request->input('city_id');
            // $user->postal_code = $request->input('postal_code') ?? '';
            $user->postal_code = null;
            // $user->ruc_tax_id = $request->input('ruc_tax_id');
            // $user->ruc_code = $request->input('ruc_code');
            $user->issuer_id = $payer_issuer->id;
            $user->registration_step_number = 'IPV_SCREEN';
            $user->latitude = $request->input('latitude');
            $user->longitude = $request->input('longitude');
            $user->address_google_map = $request->input('address_google_map');
            

            if (request()->hasFile('profile_image') && null !== $request->file('profile_image') && $request->file('profile_image')->isValid()) {
                $extension = $request->file('profile_image')->extension();
                if ($extension == 'heif') {
                    $name = str_replace(' ', '_', $request->file('profile_image')->getClientOriginalName());
                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                    $path = 'userdata/' . $user->id . '/profile/'.$fileName;
                    $getImageBlob = app('common')->heicToBlob($request->file('profile_image')->getPathName());
                    Storage::put($path, $getImageBlob);
                    $user->profile_image = $path;
                }else{                       
                    $user->profile_image = request()->file('profile_image')->store('userdata/' . $user->id . '/profile');
                } 
            }

            /*  if($request->has('is_if_company')) {
                $user->is_user_company = '1';
                if ($request->has('user_companies')) {
                    foreach ($request->input('user_companies') as $user_company) {
                        $user_comp = new UserCompany;
                        $user_comp->user_id = $user->id;
                        $user_comp->name = $user_company['name'] ?? '';
                        $user_comp->phone = $user_company['phone'] ?? '';
                        $user_comp->email = $user_company['email'] ?? '';
                        $user_comp->save();
                    }
                }
                
                if (request()->hasFile('attach_company_documents') && null !== $request->file('attach_company_documents') && $request->file('attach_company_documents')->isValid()) {
                    $user->attach_company_documents = request()->file('attach_company_documents')->store('userdata/' . $user->id . '/attach-company-documents');
                }
            } */

            $user->registration_step = 2;
            $user->save();
            
            DB::commit();

            app('common')->addLogs('Sign up to Fill your user details');
            
            Mail::to($user->email)->send(new RegisterApprovalNonApprovalWaiting($user->name));
            
            if($is_send_admin_notification == true) {
                $admin_obj = app('common')->getUserDetailsRoleBy(1);
                Notification::send($admin_obj, new NotificationAdminSignUp($user));
            }

            return redirect()->route('verify.in-person');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('details.user')->with('error',  $th->getMessage() . ' Line No  :' . $th->getLine());
        }
    }
}
