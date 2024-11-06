<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SignUp as NotificationAdminSignUp;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\UserCompany;
use App\Models\City;
use App\Models\User;
use App\Models\Plan;
use App\Models\Role;
use App\Models\UserPlanSubscription;
use App\Models\Issuer;
use App\Models\UserProfileAttach;
use Illuminate\Support\Facades\Storage;

class UserCompanyController extends Controller
{

    public function UserCongratulationsPage(Request $request)
    {
        return view('auth.user-congratulations-page');
    }

    public function create(Request $request)
    {
        $authUser = Auth()->user();
            
        if($authUser->parent_id  > 0 && $authUser->is_user_company == 1) {
            return redirect()->route('user.congratulations')->with('error', 'company already exists.');
        }

        return view('auth.user-compnay', [
            'cities' => City::getAllCities(),
        ]);
    }

    public function store(Request $request)
    {   
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');

        $img_mimes = config('constants.LOGO_IMAGE_MIMES');
        $img_mb = config('constants.LOGO_IMAGE_MAX_MB');
        $img_dim = config('constants.LOGO_IMAGE_DIMENSIONS');

        $doc_mimes = config('constants.COM_DOC_MIMES');
        $doc_mb = config('constants.COM_DOC_MAX_MB');
        $doc_dim = config('constants.COM_DOC_DIMENSIONS');

        $request->validate([
            'agree' => ['required'],
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/', 'max:255'],
            // 'birth_date' => ['required', 'date'],
            //'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city_id' => ['required', 'string', 'max:255'],
            'ruc_tax_id' => ['required', 'string', 'max:100'],
            // 'ruc_tax_id' => ['required', 'string', 'max:255','unique:issuers,ruc_text_id'],
            'profile_image' => 'required|'.$img_mimes,
            'attach_company_documents' => ['required', 'array'],
            'attach_company_documents.*' => 'required|'.$doc_mimes,
            'password' => ['required', 'confirmed', 'max:15', 'min:8', "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+/"],
            // 'attach_company_documents.*' => ['required', 'file', 'mimes:png,jpg,jpeg,pdf'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'ruc_tax_id.unique' => __('The RUC has already been taken.'),
            'password.regex' => __('The password must contain at least one lowercase letter, one uppercase letter, and one digit'),
        ]);

        DB::beginTransaction();
        try {

            $authUser = Auth()->user();
            
            if($authUser->parent_id  > 0 && $authUser->is_user_company == 1) {
                return redirect()->route('user.company-account')->with('error', 'company already exists.');
            }
            //store issuer data in issuer table
            $payer_issuer = Issuer::where('ruc_text_id', trim($request->input('ruc_tax_id')))->first();
            if(is_null($payer_issuer)){
                $payer_issuer = new Issuer;
                $payer_issuer->first_name = $request->input('first_name') ?? null;
                $payer_issuer->last_name = $request->input('last_name') ?? null;
                $payer_issuer->company_name = $request->input('first_name');
                $payer_issuer->tradename = $request->input('last_name') ;
                $payer_issuer->ruc_text_id =  $request->input('ruc_tax_id');
                $payer_issuer->ruc_code_optional = $request->input('ruc_code');
                $payer_issuer->address = $request->input('address');
                $payer_issuer->city_id = $request->input('city_id');
                $payer_issuer->registered_at = $request->input('birth_date') ? Carbon::parse($request->input('birth_date'))->format('Y-m-d') : null;
                // $payer_issuer->registered_at = date('Y-m-d');
            }
            $payer_issuer->save();

            $user = new User();
            $user->is_user_company = 1;
            $user->is_admin = 0;
            $user->parent_id = $authUser->id;
            $user->password = Hash::make($request->password);
            $user->first_name = $request->input('first_name') ?? '';
            $user->last_name = $request->input('last_name') ?? '';
            $user->email = $request->input('email') ?? '';
            $user->name = $request->input('first_name') . " " . $request->input('last_name');
            $user->birth_date = $request->input('birth_date') ? Carbon::parse($request->input('birth_date'))->format('Y-m-d') : null;
            $user->gender = $request->input('gender');
            $user->phone_number = $request->input('phone_number');
            $user->country_id = null;
            $user->state = null;
            $user->address = $request->input('address');
            $user->city_id = $request->input('city_id');
            $user->postal_code = null;
            // $user->ruc_tax_id = $request->input('ruc_tax_id');
            // $user->ruc_code = $request->input('ruc_code');
            $user->issuer_id = $payer_issuer->id;
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

            $user->registration_step = 4;
            $user->save();


            if (request()->hasFile('attach_company_documents'))
            {
                foreach ($request->file('attach_company_documents') as $documentFile) {
                    $name = str_replace(' ', '_', $documentFile->getClientOriginalName());
                    $size = round($documentFile->getSize() / 1024, 2); //  in KB
                    $extension = $documentFile->extension();
                    $lastModified = $documentFile->getMTime();
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'userdata/' . $user->id . '/attach-company-documents/'.$fileName;

                        $getImageBlob = app('common')->heicToBlob($documentFile->getPathName());
                        Storage::put($path, $getImageBlob);
                    }else{                       
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $documentFile->storeAs('userdata/' . $user->id . '/attach-company-documents', $fileName);
                    }                    

                    UserProfileAttach::create([
                        'user_id' => $user->id,
                        'name' => $name,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path,
                    ]);
                }

            }

            /* assing free plan for register user */

            //$plan = Plan::with('userLevel')->where('name', strtolower(str_replace(' ', '-', config('constants.DEFAULT_ROLES_FOR_USER_LEVELS')[0])))->first();
            $plan = Plan::with('userLevel')->where('is_free_plan', 1)->first();

            //Get role associate with this plan
            $role = Role::where('display_name', $plan->userLevel->name)->first();
            // $user = auth()->user();
            $currentDateTime = Carbon::now();

            $latest = UserPlanSubscription::latest()->first();

            if (!$latest) {
                $subscriptionNo = config('constants.SUBSCRIPTION_DEFAULT_NO');
            }else{
                $string = preg_replace("/[^0-9\.]/", '', $latest->subscription_no);
                $subscriptionNo = config('constants.SUBSCRIPTION_DEFAULT_PREFIX') . sprintf('%06d', $string+1);
            }

            $userPlanSubscription = new UserPlanSubscription();

            $userPlanSubscription->user_id = $user->id;
            $userPlanSubscription->plan_id = $plan->id;
            $userPlanSubscription->subscription_no = $subscriptionNo;
            $userPlanSubscription->name = $plan->name;
            $userPlanSubscription->currency = $plan->currency;
            $userPlanSubscription->price = $plan->price;
            $userPlanSubscription->starts_at = $currentDateTime;
            $userPlanSubscription->ends_at = $plan->expired_date;

            $userPlanSubscription->save();
            
            //Update user table with plan history
            $user->plan_id = $plan->id;
            $user->plan_status = 1;
            $user->plan_ends_at = $plan->expired_date;
            $user->save();

            //assign role according to request
            if($role){
                $user->roles()->attach([$role->id], ['user_type' => 'App\Models\User']);
            }
            
            DB::commit();

            app('common')->addLogs('user compnay account create');
            
            // Notification::send($user, new NotificationSignUp());
            if($is_send_admin_notification == true) {
                $admin_obj = app('common')->getUserDetailsRoleBy(1);
                Notification::send($admin_obj, new NotificationAdminSignUp($user));
            }

            return redirect()->route('landing');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.company-account')->with('error',  $th->getMessage() . ' Line No  :' . $th->getLine());
        }
    }
    public function companyIndex(Request $request)
    {
        return view('admin.users-company.index');
    }
    public function ajaxLoadUserComapnyData(Request $request)
    {
        $this->validate($request, [
            'search' => ['nullable', 'string'],
            'role_id' => ['nullable', 'numeric'],
            'is_active' => ['nullable', 'string'],
        ]);
    
        $perPage = $request->input('per_page') ?? config('constants.PER_PAGE_ADMIN');
        $sortType = $request->input('sort_type') ?? 'DESC';
        $sortColumn = $request->input('sort_column') ?? 'id';
        $pagination = true;
        $column_names = $request->input('column_names') ?? [];
        $req_param['sort_type'] =  $sortType;
        $req_param['sort_column'] =  $sortColumn;
        $req_param['per_page'] =  $perPage;
        $req_param['search'] =  $request->input('search', '');
        $req_param['is_active'] =  $request->input('is_active', '');
        $req_param['user_type'] =  'companies';
        $req_param['is_user_company'] = 1;

        $users = app('user-repo')->getAll($req_param, $pagination);

        return view('admin.users-company.ajax.user-companies-data-table', ['users' => $users, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage,  'column_names' => $column_names]);
    }
}
