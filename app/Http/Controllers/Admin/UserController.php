<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\BankDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Exports\UserExport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpUserAddressVerify as MailSendOtpUserAddressVerify;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\UserAlertNotify;
use App\Models\Operation;
use App\Models\Offer;
use App\Models\MiCoinsPoint;
use App\Models\IdProofDocuments;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SignUpApproved as NotificationSignUpApproved;
use App\Notifications\SignUpUnApproved as NotificationSignUpUnApproved;
use App\Notifications\WelcomingMentioningFaq as NotificationWelcomingMentioningFaq;
use App\Notifications\FlagFirstAccountWarning as NotificationFlagFirstAccountWarning;
use App\Notifications\FlagSecondAccountWarning as NotificationFlagSecondAccountWarning;
use App\Notifications\FlagThirdAccountSuspension as NotificationFlagThirdAccountSuspension;
use Illuminate\Auth\Events\Registered;
use App\Mail\OtpVerificationAndPassword;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Plan;
use App\Models\UserCompany;
use App\Notifications\ResetPassword as NotificationsResetPassword;
use App\Models\City;
use App\Models\UserProfileAttach;
use App\Notifications\SignUp as NotificationSignUp;
use App\Models\Issuer;
use App\Models\UserLevel;
use App\Models\UserPlanSubscription;
use App\Mail\CongratulationsAccountApproved;
use App\Mail\AccountNotApproved;


class UserController extends Controller
{
    public $toggle_column_names = ['ruc_id' => 'RUC ID',  'email' => "Email", 'phone' => "Phone", 'address' => "Address", 'city' => "City"];

    function __construct()
    {
        $this->middleware('permission:user_master|add-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:add-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
        $this->middleware('permission:view-user-detail', ['only' => ['show']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
        $this->middleware('permission:permanent-delete-user', ['only' => ['forceDelete']]);
        $this->middleware('permission:export-users', ['only' => ['Export']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users_column_names'] = $this->toggle_column_names;
        return view('admin.users.index', ['roles' => DB::table('roles')->select('id', 'name')->orderBy('name')->get()], $data);
    }

    /**
     * Load users data table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxLoadAdminData(Request $request)
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

        $req_param['sort_type'] =  $sortType;
        $req_param['sort_column'] =  $sortColumn;
        $req_param['per_page'] =  $perPage;
        $req_param['search'] =  $request->input('search', '');
        $req_param['is_active'] =  $request->input('is_active', '');
        $req_param['user_type'] =  'admin';

        $users = app('user-repo')->getAll($req_param, $pagination);
        
        return view('admin.users.ajax.admin-data-table', ['users' => $users, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage]);
    }

    public function ajaxLoadUserData(Request $request)
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
        $req_param['user_type'] =  'user';

        $users = app('user-repo')->getAll($req_param, $pagination);
    
        return view('admin.users.ajax.users-data-table', ['users' => $users, 'sortType' => $sortType, 'sortColumn' => $sortColumn, 'perPage' => $perPage,  'column_names' => $column_names]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'numeric', 'integer'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            // 'gender' => ['nullable', 'string'],
            'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
            // 'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/', 'unique:users'],
            'profile_image' => ['nullable', 'file', 'image'],
        ]);

        // $password = Str::random(10);
        try {

            DB::transaction(function () use ($request) {
                
                $role_id = $request->input('role_id');

                $isRoleResult = Role::where('id', $role_id)->first();

                $is_admin = '1';
                $otp = null;
                $account_type = 'Individual';
                if($isRoleResult && $isRoleResult->is_for_user_level == '1') {
                    $account_type = null;
                    $is_admin = '0';
                    $otp = app('common')->otpGenerate();
                }

                $password = $request->input('password');
    
                $user = User::create([
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($password),
                    'birth_date' => Carbon::parse($request->input('birth_date'))->format('Y-m-d'),
                    'marital_status' => $request->input('marital_status'),
                    'phone_number' => $request->input('phone_number'),
                    'country_id' => $request->input('country_id'),
                    'is_admin' => $is_admin,
                    'otp' => $otp,
                    'account_type' => $account_type,
                ]);
    
                if (request()->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
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
    
                $user->save();

                if($user && $user->is_admin == '0' && $isRoleResult->is_for_user_level == '1') {

                    Mail::to($user->email)->send(new OtpVerificationAndPassword($otp, $password));
                    
                    app('common')->addLogs('Admin Add User Register', Auth()->user()?->id);

                    $plan = Plan::with('userLevel')->where('is_free_plan', 1)->first();

                    //Get role associate with this plan
                    $role = Role::where('display_name', $plan->userLevel->name)->first();
                   
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
                }
             
                if($user && $user->is_admin == '1' && $isRoleResult->is_for_user_level == '0') {
                    //assign role according to request
                    $user->roles()->attach($request->input('role_id'), ['user_type' => 'App\Models\User']);
                }
                
            });
          
            return redirect()->route('admin.users.index')->with('success', __('User registered successfully! Credentials sent to the user'));
        } catch (\Throwable $th) {
            return redirect()->route('admin.users.create')->with('error', $th->getMessage() .'Line No. ' . $th->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('ref_by:id,referral_code,name', 'mi_coins_poinst.created_by_user:id,name', 'city:id,name', 'issuer:id,ruc_text_id,ruc_code_optional,company_name,marital_status', 'companies');

        $issuers = Issuer::select('id', 'company_name')->orderBy('id', 'desc')->get();

        $operations = Operation::OperationSelect()->where('seller_id', $user->id)->orderBy('id', 'desc')->get();
        
        $bank_details = BankDetails::where('user_id', $user->id)->orderBy('id', 'desc')->first();

        $deals = app('deals')->getAll(['buyer_id' =>  $user->id], false);

        $user_alert_notify = UserAlertNotify::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $id_proofes = IdProofDocuments::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $user_companies = [];
        if($user->is_user_company == '1') {
            $user_companies = UserCompany::where('user_id', $user->id)->get();
        }

        return view('admin.users.details', [
            'user' => $user,
            'id_proofes' => $id_proofes,
            'issuers' => $issuers,
            'bank_details' => $bank_details,
            // 'payment_options' => config('constants.PAYMENT_OPTIONS'),
            'operations' => $operations,
            'deals' => $deals,
            'user_alert_notify' => $user_alert_notify,
            'user_companies' => $user_companies,
            'cities' => City::getAllCities()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('ref_by:id,referral_code,name', 'mi_coins_poinst.created_by_user:id,name', 'user_profile_attache:id,user_id,path,extension', 'issuer:id,slug,first_name,last_name,company_name,commercial_name');

        $issuers = Issuer::select('id', 'company_name', 'ruc_text_id', 'ruc_code_optional')->orderBy('id', 'desc')->get();
        $bank_details = BankDetails::where('user_id', $user->id)->first();
        $user_alert_notify = UserAlertNotify::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $id_proofes = IdProofDocuments::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $user_companies = [];
        if($user->is_user_company == '1') {
            $user_companies = UserCompany::where('user_id', $user->id)->get();
        }

        return view('admin.users.edit', [
            'user' => $user,
            'id_proofes' => $id_proofes,
            'issuers' => $issuers,
            'bank_details' => $bank_details,
            'payment_options' => config('constants.PAYMENT_OPTIONS'),
            'user_alert_notify' => $user_alert_notify,
            'user_companies' => $user_companies,
            // 'countries' => DB::table('countries')->select('id', 'name')->get(),
            'cities' => City::getAllCities(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(isset($user->is_admin) && $user->is_admin == 1)
        {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
                'password' => ['nullable', 'confirmed'],
                'role_id' => ['required', 'numeric', 'integer'],
                'birth_date' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'string'],
                'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
                // 'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/', Rule::unique('users')->ignore($user)],
                'profile_image' => ['nullable', 'file', 'image'],
                'is_active' => ['sometimes', 'boolean'],
            ]);
            
            DB::transaction(function () use ($request, $user) {
                $user->update([ 
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'birth_date' => Carbon::parse($request->input('birth_date'))->format('Y-m-d'),
                    // 'gender' => $request->input('gender'),
                    'marital_status' => $request->input('marital_status'),
                    'phone_number' => $request->input('phone_number'),
                    'is_active' => $request->has('is_active') ? 1 : 0,
                ]);
                
                if ($request->has('password') && null !== $request->input('password')) {
                    $user->password = Hash::make($request->input('password'));
                    $user->password_changed_at = Carbon::now();
                }
    
                if ($request->hasFile('profile_image')) {
                    if ($user->profile_image){
                        Storage::delete($user->profile_image);
                    }
                    $extension = $request->file('profile_image')->extension();
                    if ($extension == 'heif') {
                        $name = str_replace(' ', '_', $request->file('profile_image')->getClientOriginalName());
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'userdata/' . $user->id . '/profile/'.$fileName;
                        $getImageBlob = app('common')->heicToBlob($request->file('profile_image')->getPathName());
                        Storage::put($path, $getImageBlob);
                        $user->profile_image = $path;
                    }else{                       
                        $user->profile_image = $request->file('profile_image')->store('userdata/' . $user->id . '/profile');
                    } 
                }
                $user->save();
                $user->syncRoles([$request->input('role_id')]);
                
            });
        } else {
            
            if($user->is_user_company == '1') {
                $request->validate([
                    'company_name' => ['required', 'string', 'max:150'],
                    'commercial_name' => ['required', 'string', 'max:150'],
                ]);
            } else {
                $request->validate([
                    'first_name' => ['required', 'string', 'max:150'],
                    'last_name' => ['required', 'string', 'max:150'],
                ]);
            }

            $request->validate([
                /*  'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'], */
                'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user)],
                'birth_date' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'string'],
                'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/'],
                // 'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/', Rule::unique('users')->ignore($user)],
                'profile_image' => ['nullable', 'file', 'image'],
                // 'payment_options' => ['required'],
                'is_active' => ['sometimes'],
                'user_profile_attache' => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf,heif'],
            ]);

                DB::transaction(function () use ($request, $user) {

                    $address_verify_otp = $request->get('address_verify_otp','');
                    $address_authorise_name = $request->get('address_authorise_name','');

                    if($request->has('send_address')) {

                        $otp = app('common')->otpGenerate();
                        $user->address_verify_otp = $otp;
                        $user->address_qr_code = $otp;
                        $user->save();
                        
                        if($user->id > 0) {
                            $emails_cc = app('common')->sendEmailCC();
                            $emails_bcc = app('common')->sendEmailBCC();
                            
                            Mail::to($user->email)
                            ->when($emails_cc, function($cc_send) use ($emails_cc){
                                $cc_send->cc($emails_cc);
                            })
                            ->when($emails_bcc, function($bcc_send) use ($emails_bcc){
                                $bcc_send->bcc($emails_bcc);
                            })
                            ->send(new MailSendOtpUserAddressVerify($user->name, $otp));
                        }
                    }

                    $address_verify_status = 'No';
                    if(!empty($user->address_verify_otp) && $user->address_verify =='No') {
                        if($user->address_verify_otp == $address_verify_otp && !empty($address_authorise_name)) {
                            $address_verify_status = 'Yes';
                            $address_verify_date = date('Y-m-d H:i:s');
                            $user->update([ 
                                'address_verify' => $address_verify_status,
                                'address_verify_at' => $address_verify_date,
                                'address_verify_otp' => $address_verify_otp,
                                'address_authorise_name' => $address_authorise_name,
                            ]);
                        } else {
                            if(!empty($address_verify_otp)) {
                                return redirect()->route('admin.users.index')->with('error', __('Invalid address OTP code'));
                            }
                        }
                    }

                    if($user->is_user_company == '1') {
                        $payer_issuer = Issuer::where('id', $user->issuer_id)->first();
                        $payer_issuer->first_name = $request->input('first_name') ?? null;
                        $payer_issuer->last_name = $request->input('last_name') ?? null;
                        $payer_issuer->company_name = $request->input('company_name');
                        $payer_issuer->commercial_name = $request->input('commercial_name');
                        $payer_issuer->registered_at = Carbon::parse($request->input('birth_date'))->format('Y-m-d');
                        $payer_issuer->save();
                    }
                
                    $user->update([
                        'email' => $request->input('email'),
                        'phone_number' => $request->input('phone_number'),
                        // 'otp' => $request->input('otp'),
                        'ipv_code' => $request->input('ipv_code'),
                        'first_name' => ($user->is_user_company == '1') ?  $request->input('company_name') :  $request->input('first_name'),
                        'last_name' => ($user->is_user_company == '1') ?  $request->input('commercial_name') :  $request->input('last_name'),
                        'birth_date' => Carbon::parse($request->input('birth_date'))->format('Y-m-d'),
                        // 'gender' => $request->input('gender'),
                        'marital_status' => $request->input('marital_status') ?? 'Single',
                        'address' => $request->input('address'),
                        'postal_code' => $request->input('postal_code'),
                        'city_id' => $request->input('city'),
                        'state' => null,
                        'country_id' => null,
                        /*   'ruc_tax_id' => $request->input('ruc_tax_id'),
                        'ruc_code' => $request->input('ruc_code'), */
                        // 'occupation' => $request->input('occupation'),
                        'bio' => $request->input('bio'),
                        'account_type' => $request->input('account_type'),
                        'ent_business_type' => $request->input('ent_business_type'),
                        'ent_no_of_users' => $request->input('ent_no_of_users'),
                        'ent_no_of_deals_per_day' => $request->input('ent_no_of_deals_per_day'),
                        'preferred_currency' => $request->input('preferred_currency'),
                        'preferred_dashboard' => $request->input('preferred_dashboard'),
                        'preferred_language' => $request->input('preferred_language'),
                        'preferred_contact_method' => $request->input('preferred_contact_method'),
                        'issuer_id' => $request->get('issuer_id'),
                        'is_active' => $request->has('is_active') ? 1 : 0,
                        'latitude' => $request->get('latitude'),
                        'longitude' => $request->get('longitude'),
                        'address_google_map' => $request->input('address_google_map'),
                    ]);
                    
                    if ($request->hasFile('profile_image')) {
                        if ($user->profile_image){
                            Storage::delete($user->profile_image);
                        }
                        $extension = $request->file('profile_image')->extension();
                        if ($extension == 'heif') {
                            $name = str_replace(' ', '_', $request->file('profile_image')->getClientOriginalName());
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                            $path = 'userdata/' . $user->id . '/profile/'.$fileName;
                            $getImageBlob = app('common')->heicToBlob($request->file('profile_image')->getPathName());
                            Storage::put($path, $getImageBlob);
                            $user->profile_image = $path;
                        }else{                       
                            $user->profile_image = $request->file('profile_image')->store('userdata/' . $user->id . '/profile');
                        } 
                    }
    
                    /*    if ($request->hasFile('id_proof_doc')) {
                        /*   if ($user->id_proof_doc){
                            Storage::delete($user->id_proof_doc);
                        }
                            $user->id_proof_doc = $request->file('id_proof_doc')->store('userdata/' . $user->id . '/profile'); \
                        */
                    /*   $id_proof_image = $request->file('id_proof_doc');
                        $name = str_replace(' ', '_', $id_proof_image->getClientOriginalName());
                        $extension = $id_proof_image->extension();
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                        $path = $id_proof_image->storeAs('userdata/' . $user->id . '/ipv', $fileName);
                        IdProofDocuments::create([
                            'user_id' => $user->id,
                            'id_proof_image' => $path,
                        ]);
                    } */

                    if ($request->hasFile('id_proof_doc')) {
                        foreach ($request->file('id_proof_doc') as $id_proof_image) {
                            $name = str_replace(' ', '_', $id_proof_image->getClientOriginalName());
                            $extension = $id_proof_image->extension();

                            if ($extension == 'heif') {
                                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                                $path = 'userdata/' . $user->id . '/ipv/'.$fileName;
        
                                $getImageBlob = app('common')->heicToBlob($id_proof_image->getPathName());
                                Storage::put($path, $getImageBlob);
                            }else{                       
                                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                                $path = $id_proof_image->storeAs('userdata/' . $user->id . '/ipv', $fileName);
                            }
                            
        
                            IdProofDocuments::create([
                                'user_id' => $user->id,
                                'id_proof_image' => $path,
                            ]);
                        }
                    }
    
                    if ($request->hasFile('ipv_image')) {
                        if ($user->ipv_image){
                            Storage::delete($user->ipv_image);
                        }
                        $extension = $request->file('ipv_image')->extension();
                        if ($extension == 'heif') {
                            $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                            $path = 'userdata/' . $user->id . '/profile/'.$fileName;
    
                            $getImageBlob = app('common')->heicToBlob($request->file('ipv_image')->getPathName());
                            Storage::put($path, $getImageBlob);
                            $user->ipv_image = $path;
                        }else{                       
                            $user->ipv_image = $request->file('ipv_image')->store('userdata/' . $user->id . '/profile');
                        }
                    }

                    if (!is_null($request->get('mi_points')) && $request->get('mi_points') != '0' && !empty($request->get('mi_points_status'))) {
                            $credit = $withdraw = 'No';

                            $total_point = MiCoinsPoint::user_by_total_micoin($user->id);
                            
                            if($request->get('mi_points_status') == 'credit') {
                                $credit = 'Yes';
                            }

                            if($request->get('mi_points_status') == 'withdraw') {
                                $withdraw = 'Yes';
                            }

                            if($total_point < $request->get('mi_points') && $withdraw == 'Yes') {
                                return redirect()->route('admin.users.edit', $user)->with('error', __('MI Coins not available'));
                            }
                    
                        MiCoinsPoint::create([
                            'user_id' => $user->id,
                            'points' => $request->get('mi_points'),
                            'title' => $request->get('mi_points_title'),
                            'credit' =>  $credit,
                            'withdraw' =>  $withdraw,
                        ]);
                    }
        
                    $user->save();

                    if($user->id > 0) {
                        if($user->is_user_company == '11') {
                            $user->is_user_company = '11';
                            if ($request->has('user_companies')) {
                                $user_companies_ids = array_filter(array_column($request->input('user_companies'), 'user_comp_id'));
                
                                if (!empty($user_companies_ids)) {
                                    UserCompany::where('user_id', $user->id)->whereNotIn('id', $user_companies_ids)->delete();
                                }
                
                                foreach ($request->input('user_companies') as $user_company)
                                {
                                    if($user_company['name']!='')
                                    {
                                        UserCompany::updateOrCreate(
                                            ['id' => $user_company['user_comp_id'] ?? null],
                                            [
                                                'name' => $user_company['name'] ?? '',
                                                'phone' => $user_company['phone'] ?? '',
                                                'email' => $user_company['email'] ?? '',
                                                'user_id' => $user->id,
                                                ]
                                            );
                                    }
                                }
                            } else {
                                UserCompany::where('user_id', $user->id)->delete();
                            }
                            
                            if (request()->hasFile('attach_company_documents') && null !== $request->file('attach_company_documents') && $request->file('attach_company_documents')->isValid()) {
                                app('common')->fileDeleteFromFolder($user->attach_company_documents);
                                $extension = $request->file('attach_company_documents')->extension();
                                if ($extension == 'heif') {
                                    $name = str_replace(' ', '_', $request->file('attach_company_documents')->getClientOriginalName());
                                    $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                                    $path = 'userdata/' . $user->id . '/attach-company-documents/'.$fileName;
                                    $getImageBlob = app('common')->heicToBlob($request->file('attach_company_documents')->getPathName());
                                    Storage::put($path, $getImageBlob);
                                    $user->attach_company_documents = $path;
                                }else{                       
                                    $user->attach_company_documents = request()->file('attach_company_documents')->store('userdata/' . $user->id . '/attach-company-documents');
                                } 
                            }
                            $user->save();
                        }
                        
                        /*  
                            $bank_save = BankDetails::where('user_id', $user->id)->first();
                            if(is_null($bank_save)) {
                                $bank_save = new BankDetails;
                            }
                            
                            $bank_save->phone_company = null;
                            $bank_save->phone_number = null;
                            $bank_save->bank_name = null;
                            $bank_save->account_name = null;
                            $bank_save->account_number = null;
                            $bank_save->identification_id = null;

                            if ($request->input('payment_options') == 'eWallet') {
                                $bank_save->phone_company = $request->input('phone_company');
                                $bank_save->phone_number = $request->input('bank_phone_number');
                                $bank_save->identification_id = $request->input('identification_id');
                            } else if ($request->input('payment_options') == 'Bank') {
                                $bank_save->bank_name = $request->input('bank_name');
                                $bank_save->account_name = $request->input('account_name');
                                $bank_save->account_number = $request->input('account_number');
                                $bank_save->identification_id = $request->input('identification_id');
                            }
                            $bank_save->user_id  = $user->id;
                            $bank_save->payment_options = $request->input('payment_options');
                            $bank_save->payment_note = $request->input('payment_note');
                            $bank_save->is_active = $request->input('is_active') ?? 'No';
                            $bank_save->save();
                        */

                        if(!empty($request->input('user_alert_type')) && !empty($request->input('user_alert_msg'))) {
                            $falg_id = $request->input('user_alert_type');
                            $user_alert_notify_save = new UserAlertNotify;
                            $user_alert_notify_save->user_id = $user->id;
                            $user_alert_notify_save->alert_id = $falg_id;
                            $user_alert_notify_save->title = $request->input('user_alert_msg');
                            $user_alert_notify_save->save();

                            if($falg_id == '1') {
                                $user_obj = app('common')->getUserEmail($user->id);
                                Notification::send($user_obj, new NotificationFlagFirstAccountWarning(app()->getLocale()));
                                app('common')->addLogs('send email user Account warning', $user_obj->id);
                            } else if($falg_id == '2') {
                                $user_obj = app('common')->getUserEmail($user->id);
                                Notification::send($user_obj, new NotificationFlagSecondAccountWarning(app()->getLocale()));
                                app('common')->addLogs('send email user Second Account warning', $user_obj->id);
                            } else if($falg_id == '3') {
                                $user_obj = app('common')->getUserEmail($user->id);
                                Notification::send($user_obj, new NotificationFlagThirdAccountSuspension(app()->getLocale()));
                                app('common')->addLogs('send email user Account suspension', $user_obj->id);
                            }
                        }

                        if ($request->hasFile('user_profile_attache')) 
                        {
                            $user_profile_attache = $request->file('user_profile_attache');
                            $name = str_replace(' ', '_', $user_profile_attache->getClientOriginalName());
                            $size = round($user_profile_attache->getSize() / 1024, 2); //  in KB
                            $extension = $user_profile_attache->extension();
                            $lastModified = $user_profile_attache->getMTime();
                            if ($extension == 'heif') {
                                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                                $path = 'userdata/' . $user->id . '/profile-document/'.$fileName;
        
                                $getImageBlob = app('common')->heicToBlob($user_profile_attache->getPathName());
                                Storage::put($path, $getImageBlob);
                            }else{                       
                                $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.' . $extension;
                                $path = $user_profile_attache->storeAs('userdata/' . $user->id . '/profile-document', $fileName);
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
                });
        }

        return redirect()->route('admin.users.edit', $user)->with('success', (($user->is_user_company == '1') ? __('Compnay updated successfully') : __('User updated successfully')));
    }

    public function ajaxApproveUser(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string', 'uuid'],
        ]);

        DB::beginTransaction();
        try {

            $is_update = User::where('slug', $request->input('user_id'))->update([
                'is_registered' => true,
                'registered_at' => Carbon::now(),
            ]);
            
            DB::commit();

            $user_obj = User::where('slug', $request->input('user_id'))->select('id', 'name', 'email', 'account_type', 'as_borrower', 'as_investor', 'is_registered', 'is_active', 'address_verify', 'user_level')->first();
    
            app('common')->addLogs('Congratulations Account Approved Email', $user_obj->id);
            
            Mail::to($user_obj->email)->send(new CongratulationsAccountApproved($user_obj->name));
            
            /*  Notification::send($user_obj, new NotificationSignUpApproved(app()->getLocale()));

            app('common')->addLogs('send email user approved', $user_obj->id);
            
            Notification::send($user_obj, new NotificationWelcomingMentioningFaq(app()->getLocale()));
            
            app('common')->addLogs('EMAIL welcoming mentioning FAQs and how mipo works, the basics 101 and the status levels + enterprise differences', $user_obj->id); */
            
            $response = [
                'status' => true,
                'message' => __('User register approved successfully'),
            ];

        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => false,
                'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
            ];
        }

        return response()->json($response);
    }

    public function ajaxRejectUser(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string', 'uuid'],
        ]);

        $user_id = $request->input('user_id');
        
        DB::beginTransaction();
        try {
            
            $is_user = User::where('slug', $user_id)->update([
                'is_registered' => false,
                'registered_at' => null,
                'registration_step' => 2,
            ]);
            DB::commit();

            
            $user_obj = User::where('slug', $request->input('user_id'))->select('id', 'name', 'email', 'account_type', 'as_borrower', 'as_investor', 'is_registered', 'is_active', 'address_verify', 'user_level')->first();

            app('common')->addLogs('Account Not Approved Email', $user_obj->id);
            
            Mail::to($user_obj->email)->send(new AccountNotApproved($user_obj->name));

            // Notification::send($user_obj, new NotificationSignUpUnApproved(app()->getLocale()));

            $response = [
                'status' => true,
                'message' => __('User register rejected successfully'),
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => false,
                'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
            ];
        }

        return response()->json($response);
    }

    public function destroy(Request $request, $slug)
    {
        DB::beginTransaction();
        try {
            $type = null;
            $user = User::withTrashed()->where('slug', $slug)->first();
            if($user)
            {
                $user_id = $user->id;
                if(is_null($user->deleted_at) && empty($user->deleted_at))
                {
                    $is_user_operation = Operation::where('seller_id',$user_id)->delete();
                    $is_user_bank = BankDetails::where('user_id', $user_id)->delete();
                    $is_user_offer = Offer::where('buyer_id', $user_id)->delete();
                    $is_user = User::where('id', $user_id)->delete();
                    DB::commit();

                    $type = 'restore';
                    $message = "Deleted successfully";
                    /* $user->deleted_at = Carbon::now();
                    app('operation')->delete(null, $user->id); */
                } else {
                    $is_user_operation = Operation::withTrashed()->where('seller_id', $user_id)->restore();
                    $is_user_bank = BankDetails::withTrashed()->where('user_id', $user_id)->restore();
                    $is_user_offer = Offer::withTrashed()->where('buyer_id', $user_id)->restore();
                    $is_user = User::withTrashed()->where('id', $user_id)->restore();
                    DB::commit();

                    $type = 'delete';
                    $message = "Restore successfully";
                    /*  $user->deleted_at = null;
                    app('operation')->restore($user->id); */
                }
                // $user->save();
                $response = [
                    'status' => true,
                    'message' => __($message),
                    'data' => ['type' => __($type)]
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Something went wrong please try again!'),
                    'data' => ['type' => __($type)]
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => false,
                'message' => $th->getMessage() . 'Line No. ' . $th->getLine(),
            ];
        }
        return response()->json($response);
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            \DB::beginTransaction();
            try {
                $user = User::withTrashed()->where('slug', $slug)->first();
                if($user)
                {
                    $user_id = $user->id;
                    $issuer_id = $user->issuer_id;

                    $is_operation = Operation::where('seller_id', $user_id)->withTrashed()->count();
                    $is_user_offer = Offer::where('buyer_id', $user_id)->withTrashed()->count();
                    $is_issuer = Issuer::where('id', $issuer_id)->withTrashed()->count();
                    
                    if($is_operation > 0 || $is_user_offer > 0 || $is_issuer > 0) {
                        $response = [
                            'status' => false,
                            'message' => __('Can not delete user Associated data exists, please delete them first'),
                            'data' => ''
                        ];

                        return response()->json($response);
                    }

                    if($user->profile_image!='') {
                        // app('operation')->delete(null, $user->id);
                        app('operation')->forceDelete(null, $user->id);
                        Storage::delete($user->profile_image);
                    }
                    
                    Issuer::where('id', $issuer_id)->forceDelete();
                    $user->forceDelete();

                    \DB::commit();
                    $response = [
                        'status' => true,
                        'message' => __('Deleted successfully'),
                        'data' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('User no found'),
                        'data' => ''
                    ];
                }
            } catch (\Throwable $th) {
                \DB::rollBack();
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }

    public function Export(Request $request)
    {
        if ($request->ajax()) 
        {
            try {
                $path = 'export/export_users_'.time().'.xlsx';

                $param = $request->only('search');
                
                $result = (new UserExport($param))->store($path);

                $file_downalod = \Route('secure-file', Crypt::encryptString($path));

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
            abort(404, __('File not found!'));
        }
    }

    public function ajaxSendOtpUserAddress(Request $request, $user_slug)
    {
        if($request->ajax())
        {
            DB::beginTransaction();
            try {
                $user = User::where('slug', $user_slug)->first();
                if($user)
                {
                    $otp = app('common')->otpGenerate();
                    $user->address_verify_otp = $otp;
                    $user->save();
                    
                    if($user->id > 0) {
                        $emails_cc = app('common')->sendEmailCC();
                        $emails_bcc = app('common')->sendEmailBCC();
                        
                        Mail::to($user->email)
                        ->when($emails_cc, function($cc_send) use ($emails_cc){
                            $cc_send->cc($emails_cc);
                        })
                        ->when($emails_bcc, function($bcc_send) use ($emails_bcc){
                            $bcc_send->bcc($emails_bcc);
                        })
                        ->send(new MailSendOtpUserAddressVerify($user->name, $otp));
                    }
                    
                    DB::commit();
                    $response = [
                        'status' => true,
                        'message' => __('Email send successfully'),
                        'data' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('User no found'),
                        'data' => ''
                    ];
                }
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
            abort(404, 'File not found!');
        }
    }

    public function ajaxKycUserAddress(Request $request, $user_slug, $pdf_type)
    {
        /* if($request->ajax())
        { */
            ini_set('max_execution_time', 0);
            try {
                $user = User::where('slug', $user_slug)->first();
                if($user)
                {
                    $data['date'] = date('d/m/Y');
                    $filePath = "/admin/pdf/";
                    if($pdf_type == 'user-kyc') {
                        $otp = app('common')->otpGenerate();
                        $user->address_verify_otp = $otp;
                        $user->address_verify = 'No';
                        $user->save();
                        
                        $data['user'] = app('user-repo')->findByIdOrSlug($user_slug)->load('city:id,name', 'issuer:id,ruc_text_id,company_name');
                        
                        $fileName = 'public_address_kyc_'.time().'.pdf';
                        
                        $pdf = Pdf::loadView('admin.users.pdf.kyc-address-verification', $data);
                        return $pdf->download($fileName);
                    } else if($pdf_type == 'user-account') { 

                        $data['user'] = app('user-repo')->findByIdOrSlugUserDetail($user_slug);
                        
                        $fileName = 'user_account_'.time().'.pdf';
                        
                        $pdf = Pdf::loadView('admin.users.pdf.users-account-pdf', $data);

                        return $pdf->download($fileName);
                    } else if($pdf_type == 'user-account-activity') {

                        $data['user'] = app('user-repo')->findByIdOrSlugUserDetail($user_slug);
                        
                        $req['op_status'] = ['Approved'];
                        $req['user_id'] = $data['user']->id;

                        $data['user_active_operations'] = app('user-repo')->userByOperation($req);
                    
                        $data['user_sold_operations'] = app('user-repo')->userSoldAndBuyByOperation([$req + ['user_type' => 'seller']]);

                        $data['user_buy_operations'] = app('user-repo')->userSoldAndBuyByOperation([$req + ['user_type' => 'buyer']]);
                        
                        $fileName = 'user_account_activity_'.time().'.pdf';
                        
                        /* create pdf */
                        $pdf = Pdf::loadView('admin.users.pdf.user-activity-pdf', $data);

                        // return $pdf->download($fileName);

                        return $pdf->stream(); 
                    }

        
                    /*  $file_full_path = storage_path('app'.$file_path.$pdf_file_name);
                    
                    $headers = [
                        'Content-Type' => 'application/pdf',
                    ];
                    
                    $content = $pdf->download()->getOriginalContent();
        
                    Storage::put($file_path.$pdf_file_name, $content);
        
                    return response()->download($file_full_path, $pdf_file_name, $headers)->deleteFileAfterSend(false); */

                    $response = [
                        'status' => true,
                        'message' => __('Email send successfully'),
                        'data' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('User no found'),
                        'data' => ''
                    ];
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
       /*  } else {
            abort(404, 'File not found!');
        } */
    }

    public function ajaxActiveInactiveUser(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ]);
        
        try {

            $user_id = $request->input('id');
            $is_user = User::where('id', $user_id)->first();

            if(!$is_user) {
                $response = [
                    'status' => false,
                    'message' => __('Record not found'),
                    'data' => []
                ];
                return response()->json($response);
            }

            $is_active = ($is_user->is_active == '1') ? '0' : '1';
            $msg = ($is_user->is_active == '1') ? 'User block successfully' : 'User active successfully';
            $is_valid = false;

            if($is_user->is_registered == false || is_null($is_user->registered_at)) {
                $is_user->is_registered = true;
                $is_user->registered_at = Carbon::now();
                $is_user->is_active = $is_active;
                $is_user->save();
                $is_valid = true;
                
                /*  Notification::send($is_user, new NotificationSignUpApproved(app()->getLocale()));
                
                app('common')->addLogs('send email user approved', $is_user->id);
                
                Notification::send($is_user, new NotificationWelcomingMentioningFaq(app()->getLocale()));
                
                app('common')->addLogs('EMAIL welcoming mentioning FAQs and how mipo works, the basics 101 and the status levels + enterprise differences', $is_user->id);
                
                app('common')->addLogs('user '.$msg, $is_user->id); */

                app('common')->addLogs('Congratulations Account Approved Email', $is_user->id);
                
                Mail::to($is_user->email)->send(new CongratulationsAccountApproved($is_user->name));
                
                app('common')->addLogs('user '.$msg, $is_user->id);

            } else {
                $is_valid = true;
                $is_user->is_active = $is_active;
                $is_user->save();
                
                app('common')->addLogs('user '.$msg, $is_user->id);

                if($is_user->is_active == '0') {

                    $user_obj = app('common')->getUserEmail($is_user->id);

                    Mail::to($user_obj->email)->send(new AccountNotApproved($user_obj->name));

                    app('common')->addLogs('Account Not Approved Email', $is_user->id);
                }

                if($is_user->is_active == '1') {
                    app('common')->addLogs('Congratulations Account Approved Email', $is_user->id);
                
                    Mail::to($is_user->email)->send(new CongratulationsAccountApproved($is_user->name));
                }
            }
            
            if($is_valid) {
                $response = [
                    'status' => true,
                    'message' => __($msg),
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Record not found'),
                    'data' => []
                ];
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th,
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function loginAsUser($slug){
        //Store super admin user into session
        $authUser = Auth::user();
        $user = User::where('slug',$slug)->first();
        //Logout current login user
        Auth::logout(); 
        session()->invalidate(); 
        session()->regenerateToken();
        //dd($user,$authUser);
        Auth::login($user);
        // Setting a single session value.
        if($user->is_admin){
            session()->put('authAdminUser', $authUser->slug);
        }else{
            session()->put('authWebsiteUser', $authUser->slug);
        }
        return redirect()->route('dashboard');
    }

    public function backToSuperAdminLogin(){
        $adminUserSlug = session('authAdminUser');
        $user = User::where('slug',$adminUserSlug)->first();
        //Logout current login user
        Auth::logout(); 
        session()->invalidate(); 
        session()->regenerateToken();
        //dd($user,$authUser);
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }

    public function loginAsWebsiteUser($slug){
        //Store super admin user into session
        $authUser = Auth::user();
        $user = User::where('slug',$slug)->first();
        //Logout current login user
        Auth::logout(); 
        session()->invalidate(); 
        session()->regenerateToken();
        //dd($user,$authUser);
        Auth::login($user);
        // Setting a single session value.
        if($user->is_admin){
            session()->put('authAdminUser', $authUser->slug);
        }else{
            session()->put('authWebsiteUser', $authUser->slug);
        }
        return redirect()->route('dashboard');
    }

    public function backToWebsiteLogin(){
        $adminWebsiteSlug = session('authWebsiteUser');
        $user = User::where('slug',$adminWebsiteSlug)->first();
        //Logout current login user
        Auth::logout(); 
        session()->invalidate(); 
        session()->regenerateToken();
        //dd($user,$authUser);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function getUserPlanModal($slug){
        $plans = Plan::all();
        $user = User::where('slug',$slug)->first();
        $view = view('admin.users.modal.plan-modal',compact('plans','user'))->render();
        return response()->json([
            'status' => true,
            'view' => $view
        ]);
    }

    public function updateUserPlan($slug){
        $plan = Plan::with('userLevel')->where('slug',$slug)->first();
        //Get role associate with this plan
        $role = Role::where('display_name',$plan->userLevel->name)->first();
        $user = auth()->user();
        $currentDateTime = Carbon::now();

        $latest = UserPlanSubscription::latest()->first();
        if (! $latest) {
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
        return redirect()->back()->with('success', __('Plan updated successfully'));
    }
    
    public function ajaxSendResetPwdLink(Request $request,$slug){
        if($slug){
            $user = User::where('slug', $slug)->first();
            $token = Str::random(64);

            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => Carbon::now()]
            );        

            try {
                $user->notify(new NotificationsResetPassword($user, $token));
                $response = [
                    'status' => true,
                    'message' => __('Password reset link e-mailed to user successfully'),
                    'data' => []
                ];
            } catch (\Throwable $th) {
                //throw $th;
                $response = [
                    'status' => false,
                    'message' => __('Something went wrong please try again!'),
                    'data' => []
                ];
            }
        }else{
            $response = [
                'status' => false,
                'message' => __('Something went wrong please try again!'),
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function createCompanyAccount(Request $request, $slug)
    {
        $img_mimes = config('constants.LOGO_IMAGE_MIMES');
        $img_mb = config('constants.LOGO_IMAGE_MAX_MB');
        $img_dim = config('constants.LOGO_IMAGE_DIMENSIONS');

        $request->validate([
         /*    'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'], */
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'phone_number' => ['required', 'string', 'min:10', 'max:15'],
            'registered_at' => ['required', 'date'],
            'address' => ['required', 'string'],
            'city' => ['required'],
            'ruc_tax_id' => ['required', 'string', 'max:150','unique:issuers,ruc_text_id'],
            'profile_image' => 'nullable|'.$img_mimes,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        ['ruc_tax_id.unique' => 'The RUC has already been taken.']);

        DB::beginTransaction();
        try {
            $is_user = User::where('slug', $slug)->select('id', 'slug', 'parent_id')->first();

            $is_user_compny = User::where('parent_id', $is_user->id)->count();
            
            if($is_user_compny > 0) {
                return \Redirect::back()->with('error', __('Company already exists'));
            }
        
            $payer_issuer = new Issuer;
            $payer_issuer->first_name = $request->input('company_name');
            $payer_issuer->last_name = $request->input('commercial_name');
            $payer_issuer->company_name = $request->input('company_name');
            $payer_issuer->commercial_name = $request->input('commercial_name') ;
            $payer_issuer->ruc_text_id =  $request->input('ruc_tax_id');
            $payer_issuer->ruc_code_optional = $request->input('ruc_code');
            $payer_issuer->address = $request->input('address');
            $payer_issuer->city_id = $request->input('city');
            $payer_issuer->registered_at = Carbon::parse($request->input('registered_at'))->format('Y-m-d');
            $payer_issuer->save();
    
            $user = new User();
            $user->is_user_company = 1;
            $user->is_admin = 0;
            $user->parent_id = $is_user->id;
            $user->password = Hash::make($request->password);
            $user->first_name = $request->input('company_name');
            $user->last_name = $request->input('commercial_name');
            $user->email = $request->input('email');
            $user->name = $request->input('first_name') . " " . $request->input('last_name');
            $user->birth_date = Carbon::parse($request->input('registered_at'))->format('Y-m-d');
            $user->phone_number = $request->input('phone_number');
            $user->state = null;
            $user->address = $request->input('address');
            $user->city_id = $request->input('city');
            $user->latitude = $request->input('latitude');
            $user->longitude = $request->input('longitude');
            $user->postal_code = null;
            $user->issuer_id = $payer_issuer->id;
            $user->account_type = 'Individual';
    
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

            $user->save();
            
            if($user && $user->is_admin == '0' && $user->is_user_company == '1') {
                
                $otp = app('common')->otpGenerate();

                Mail::to($user->email)->send(new OtpVerificationAndPassword($otp, $request->password));
                
                app('common')->addLogs('Admin Add User company Register', Auth()->user()?->id);

                $plan = Plan::with('userLevel')->where('is_free_plan', 1)->first();

                //Get role associate with this plan
                $role = Role::where('display_name', $plan->userLevel->name)->first();
               
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
            }

            DB::commit();
            
            app('common')->addLogs('admin create user compnay account create');
                
            Notification::send($user, new NotificationSignUp());
            
            /*  $token = Str::random(64);

            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => Carbon::now()]
            );      

            $user->notify(new NotificationsResetPassword($user, $token)); */

            return redirect()->route('admin.users.company')->with('success', __('Company added successfully'));
        } catch (\Throwable $th) {
            DB::rollback();
            return \Redirect::back()->with('error', $th->getMessage() . ' Line No  :' . $th->getLine());
        }
    }

    public function ajaxDeleteImage(Request $request, $id)
    {
        if ($request->ajax()) {
            try {
                
                $request->validate([
                    'table_name' => 'required',
                ]);

                $table_name = $request->table_name;
                $is_delete = false;
                if($table_name == 'profile_attaches') {
                       
                    $result = UserProfileAttach::where('id',$id)->first();
                    app('fileupload')->fileDeleteFromFolder($result->path);
                    $is_delete = $result->forceDelete() ? true :false;
                }

                if($is_delete)
                {
                    $response = [
                        'status' => true,
                        'message' => __('Image deleted successfully'),
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