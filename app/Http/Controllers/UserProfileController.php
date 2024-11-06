<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use App\Models\{User, InviteFriends, Issuer, Favorite, BankDetails, IssuerBank, MiCoinsPoint};
use Twilio\Rest\Client;
use App\Mail\OtpVerification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InviteFriend as MailInviteFriend;
use App\Mail\VerifyAddressSuccess as MailVerifyAddressSuccess;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddEnterpriseSubUser as NotificationAddEnterpriseSubUser;
use Illuminate\Auth\Events\Registered;
use App\Mail\OtpVerificationAndPassword;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use App\Models\UserProfileAttach;
use App\Models\City;
use App\Models\UserLevel;
use App\Notifications\SignUp as NotificationAdminSignUp;
use App\Mail\RegisterApprovalNonApprovalWaiting;

class UserProfileController extends Controller
{

    public function index()
    {   
        $language = config('constants.languages');
        $preferred_dashboard = config('constants.PREFERRED_DASHBOARD_Arr');
        $currency_type = config('constants.CURRENCY_TYPE');
        $preferred_contact_method = config('constants.PREFERRED_CONTACT_METHOD');
        $account_type = config('constants.ACCOUNT_TYPE');
        
        $notifications = app('setting-notification-repo')->getAll();

        $referrer_code = Auth()->user()->referral_code;

        $user = User::with('city:id,name', 'issuer')->withAvg('ratings', 'rating_number')->where('id', Auth()->user()->id)->first();
        if(!$user) {
            return redirect('/');
        }

        //Get permission list
        $permissions = Permission::whereNull('parent_id')
                    ->where('is_for_user',1)
                    ->with('childrenPermissions')
                    ->get();

        $roles = Role::where('created_by', Auth()->user()->id)->get();

        $banks = IssuerBank::select('id', 'name')->orderBy('name', 'asc')->get();   
    
        $userLevels = UserLevel::getUserLevel();

        $total_micoin_credit = MiCoinsPoint::user_by_total_micoin(Auth()->user()->id);      
    
        return view('user-profile.index',
            [
                'user' => $user , 'countries' => [], 'roles' => $roles,
                'language'  => $language,  'preferred_dashboard' => $preferred_dashboard,    
                'currency_type'  => $currency_type,  'preferred_contact_method' => $preferred_contact_method, 'account_type' => $account_type,
                'favorites' => [],
                'notifications' => $notifications,
                'referrer_code' => $referrer_code,
                'permissions' => $permissions,
                'banks' => $banks,
                'total_micoin_credit' => $total_micoin_credit,
                "cities" => City::getAllCities(),
                'userLevels' => $userLevels
            ]);
    }

    public function store(Request $request)
    {
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');
        $user = auth()->user();
        $subUserCounts = $user->subUsers->count();
        $planUserLimit = ($user->plan) ? $user->plan->multi_user_account : 0;
       /*  if($subUserCounts > (int)$planUserLimit){
            $response = [
                'status' => false,
                'message' => __('You reach to user limit please upgrade plan to create more users.'),
                'data' => []
            ];
            return response()->json($response);
        } */
        $action = $request->input('action');
        $user_id = $request->input('user_id', '');

        $request->validate([
            'user_id' =>  ($user_id!='') ? 'required' : 'nullable',
            'action' => 'required|in:Add,Update',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,'. $user_id,
            'phone_number' => 'required|regex:/^([0-9\ \-\+\(\)]*)$/|min:10',
            'password' => ['required', 'confirmed', 'max:15', 'min:8', "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+/"],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults(), 'max:15', 'min:8'],
            // 'phone_number' => 'required|regex:/^([0-9\ \-\+\(\)]*)$/|min:10|unique:users,phone_number,'.$user_id,
            'role_id' => 'required',
        ],[
            'password.regex' => __('The password must contain at least one lowercase letter, one uppercase letter, and one digit'),
        ]);

        if ($request->ajax())
        {
            DB::beginTransaction();
            try {
                $msg = "";
                if($action == 'Add')
                {
                    $otp = app('common')->otpGenerate();

                    $password = $request->password;
                    // $password = app('common')->randomPasswordGenerate();

                    $user = User::create([
                        'enterprise_id' => Auth()->user()->id,
                        'email' => $request->email,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'name' => $request->first_name. ' '. $request->last_name,
                        'phone_number' => $request->phone_number,
                        'password' => Hash::make($password),
                        'otp' => $otp,
                        'account_type' => config('constants.ACCOUNT_TYPE')[0],
                        'is_admin' => 0,
                    ]);

                    if($is_send_admin_notification == true) {
                        $admin_obj = app('common')->getUserDetailsRoleBy(1);
                        Notification::send($admin_obj, new NotificationAdminSignUp($user));
                    }
                    
                    Mail::to($user->email)->send(new RegisterApprovalNonApprovalWaiting($user->name));

                    // Notification::send($user, new NotificationAddEnterpriseSubUser(app()->getLocale()));

                    if($request->role_id){
                        //assign role according to request
                        $user->roles()->attach([$request->role_id], ['user_type' => 'App\Models\User']);
                    }
                    event(new Registered($user));

                    Mail::to($user->email)->send(new OtpVerificationAndPassword($otp, $password));

                    // Mail::to($user)->send(new OtpVerification($otp));

                    app('common')->addLogs('Add enterprise User', Auth()->user()?->id);
                    $msg = "User added successfully";
                } else if($action == 'Update') { 
                    $user = User::where(['id' => $user_id, 'enterprise_id' =>  Auth()->user()->id])
                    ->update([
                        'enterprise_id' => Auth()->user()->id,
                        'email' => $request->email,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'name' => $request->first_name. ' '. $request->last_name,
                        'phone_number' => $request->phone_number,
                        'is_admin' => 0,
                    ]);

                    app('common')->addLogs('update enterprise User', Auth()->user()?->id);
                    if($request->role_id){
                        $user->syncRoles([$request->role_id]);
                    }
                    $msg = "User updated successfully";
                }

                $response = [
                    'status' => true,
                    'message' => __($msg),
                    'data' => []
                ];
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }
    
    public function ajaxSellerList(Request $request)
    {
        if($request->ajax())
        {
            $all_seller = [];
            $search = $request->get('search');
            if(!empty($search)) {
                
                $request_param = ($request->all() + ['login_user_id' =>  Auth()->user()->id]);
                
                $result_data = app('offer')->OfferBySellerName($request_param);

                if (isset($result_data) && count($result_data) > 0) {
                    $seller_names = $result_data->pluck('seller')->flatten()->pluck('name', 'id')->toArray();
                    foreach ($seller_names as $key => $val) {
                        $all_seller[] = [
                            'id' => $key,
                            'text' => $val,
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

    public function ajaxBuyerList(Request $request)
    {
        if($request->ajax())
        {
            $all_issuers = [];
            $search = $request->get('search');
            if(!empty($search))
            {
                $request_param = ($request->all() + ['login_user_id' =>  Auth()->user()->id]);
                $result_data = app('offer')->OfferByIssuersName($request_param);
                if (isset($result_data) && count($result_data) > 0) {
                    $issuers_names = $result_data->pluck('issuer')->flatten()->pluck('name', 'id')->toArray();
                    foreach ($issuers_names as $key => $val) {
                        $all_issuers[] = [
                            'id' => $key,
                            'text' => $val,
                        ];
                    }
                }
            }

            $response = [
                'status' => true,
                'message' => '',
                'data' => $all_issuers
            ];
            return response()->json($response);
        }
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // 'gender' => 'required',
            'user_profile_attache' => 'nullable|file|mimes:png,jpg,jpeg,pdf,heif'
        ]);
        if($request->ajax())
        {
            try {
                $user = User::where('slug', $slug)->first();
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->name =  $request->input('first_name') . " " .  $request->input('last_name');
             /* 
                $user->birth_date = Carbon::parse($request->input('birth_date'))->format('Y-m-d');
                $user->gender = $request->input('gender');
                $user->country_id = $request->input('country_id');
                $user->state = $request->input('state');
                $user->address = $request->input('address');
                $user->city = $request->input('city');
                $user->postal_code = $request->input('postal_code'); 
                */
                
                /*if (request()->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
                    app('common')->fileDeleteFromFolder($user->profile_image);
                    $user->profile_image = $request->file('profile_image')->store('userdata/' . $user->id . '/profile');
                }*/
                if($request->input('oldpassword') !='' && $request->input('confirmpassword')!='' && $request->input('newpassword')!='')
                {
                    if (\Hash::check($request->oldpassword, $user->password)) { 
                        $user->password = $request->input('newpassword');
                    } else {
                        $response = [
                            'status' => false,
                            'message' => __('Old password does not match'),
                            'data' => ''
                        ];
                        return response()->json($response);
                    }  
                }  
                
                if ($request->hasFile('user_profile_attache')) 
                {
                    /* $user_profile_attache = $request->file('user_profile_attache');
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
                    } */

                    $storagePath = app('fileupload')->uploadPathRename(config('filepath.users.attach_doc'), $user->id);
                    $file_upload_data = app('fileupload')->uploadFile($request->file('user_profile_attache'), $storagePath);

                    UserProfileAttach::create([
                        /* 'user_id' => $user->id,
                        'name' => $name,
                        'size' => $size,
                        'extension' => $extension,
                        'last_modified' => $lastModified,
                        'path' => $path, */
                        'user_id' => $user->id,
                        'name' => $file_upload_data['file_org_name'],
                        'size' => $file_upload_data['file_size'],
                        'extension' => $file_upload_data['file_extension'],
                        'last_modified' => $file_upload_data['file_last_modified'],
                        'path' => $file_upload_data['file_path'].'/'.$file_upload_data['file_new_name'],
                    ]);
                }

                $user->save();

                if($user->is_user_company == '1') {
                    $issuer_update = Issuer::where('id', $user->issuer_id)->first();
                    $issuer_update->company_name = $request->input('first_name');
                    $issuer_update->commercial_name = $request->input('last_name');
                    $issuer_update->save();
                }

                $response = [
                    'status' => true,
                    'message' => __('User updated successfully'),
                    'data' => [$user]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function inviteFriend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'email' => 'required|email|unique:invite_friends,email',
            // 'referral_code' => 'required',
        ]);

        if($request->ajax())
        {
            try {

                $cc = config('constants.CC');
                $is_send_cc = $cc['SEND'];
                $emails_cc = collect($cc['EMAILS'])->where('send', true)->pluck('email')->toArray();

                $bcc = config('constants.BCC');
                $is_send_bcc = $bcc['SEND'];
                $emails_bcc = collect($bcc['EMAILS'])->where('send', true)->pluck('email')->toArray();

                $email_invite = $request->input('email');
                $referral_code = Auth()->user()->referral_code;
                $invitation_token = app('common')->generateInvitationToken();
                $referral_link = route('register').'?ref='.$invitation_token;
                
                $save_invite_friend = new InviteFriends;
                $save_invite_friend->user_id = Auth()->user()->id;
                $save_invite_friend->email = $email_invite;
                $save_invite_friend->invitation_token = $invitation_token;
                $save_invite_friend->invitation_token_expire = Carbon::now();;
                $save_invite_friend->referral_code = Auth()->user()->referral_code;
                $save_invite_friend->save();

                if($save_invite_friend->id > 0) {
                    
                    app('common')->addLogs('send referral code', Auth()->user()->id);

                    Mail::to($email_invite)
                    ->when($is_send_cc, function($cc_send) use ($emails_cc){
                        $cc_send->cc($emails_cc);
                    })
                    ->when($is_send_bcc, function($bcc_send) use ($emails_bcc){
                        $bcc_send->bcc($emails_bcc);
                    })
                    ->send(new MailInviteFriend(Auth()->user()->name, $referral_code, $referral_link));
                }
                
                $response = [
                    'status' => true,
                    'message' => __('Email send successfully'),
                    'data' => []
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function userProfileSetting(Request $request)
    {
        if($request->ajax())
        {
            try {
                $type = $request->input('type');
                $user_login_id = $request->input('user_login_id');

                $user = User::where('slug', $user_login_id)->first();
                if(!$user)
                {
                    $response = [
                        'status' => false,
                        'message' => __('User no found'),
                        'data' => []
                    ];
                    return response()->json($response);
                }

                if($type == 'preferred_dashboard' && !empty($request->input('preferred_dashboard'))) 
                {
                    $user->preferred_dashboard = $request->input('preferred_dashboard');
                } else if($type == 'preferred_currency' && !empty($request->input('preferred_currency')))
                {
                    $user->preferred_currency = $request->input('preferred_currency');
                } else if($type == 'preferred_contact_method' && !empty($request->input('preferred_contact_method')))
                {
                    $user->preferred_contact_method = $request->input('preferred_contact_method');
                } else if($type == 'language' && !empty($request->input('language')))
                {
                    $user->language = $request->input('language');
                }
                    $user->save();
                    $response = [
                        'status' => true,
                        'message' => __('User profile setting updated successfully'),
                        'data' => []
                    ];
            } catch (\Throwable $th) {
                    $response = [
                        'status' => false,
                        'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                        'data' => []
                    ];
            }
                return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxUserFileUpload(Request $request, $slug)
    {
        $request->validate([
            'profile_image' => 'required|mimes:png,jpg,jpeg,heif',
        ]);

        if($request->ajax())
        {
            try {
                if (request()->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
                    $user = User::where('slug', $slug)->first();
                    app('common')->fileDeleteFromFolder($user->profile_image);
                    $extension = $request->file('profile_image')->extension();
                    $name = str_replace(' ', '_', $request->file('profile_image')->getClientOriginalName());
                    if ($extension == 'heif') {
                        $fileName = pathinfo($name, PATHINFO_FILENAME) . '_' . date('Ymd_His') . '.'.config('constants.HEIC_TO_OTHER_FORMAT');
                        $path = 'userdata/' . $user->id . '/profile/'.$fileName;
                        $getImageBlob = app('common')->heicToBlob($request->file('profile_image')->getPathName());
                        Storage::put($path, $getImageBlob);
                        $user->profile_image = $path;
                    }else{ 
                        $user->profile_image = $request->file('profile_image')->store('userdata/' . $user->id . '/profile');
                    }

                    /* $storagePath = app('fileupload')->uploadPathRename(config('filepath.users.profile'), $user->id);
                    $file_upload_data = app('fileupload')->uploadFile($request->file('profile_image'), $storagePath);

                    $user->profile_image = $file_upload_data['file_path'].'/'.$file_upload_data['file_new_name']; */
                    $user->save();

                    $response = [
                        'status' => true,
                        'message' => __('File uploaded successfully'),
                        'data' => [$user]
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
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function publicProfileSeller(Request $request, $slug = null)
    {
        $user = app('common')->publicProfileSeller($slug, $profile_type ="public");

        if(!$user) {
            return redirect('/');
        }
        
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $param = array();
        
        $param['user_id'] =  $user->id;
        $param['seller_id'] =  $user->id;
        $param['page_name'] = 'operations';
        
        // $mi_operations_dashboard = app('operation')->getOperationDashboardWeb($param, $pagination = false);
            
        $operations_status_dashboard = app('dashboard')->operationStatus($param);

        $average_retention = app('dashboard')->averageRetention($param);

        $average_operation_values = app('dashboard')->averageOperationValue($param);

        $average_rating_days = app('dashboard')->averageRatingDays($param);

        $pichart_data = app('dashboard')->getUserProfilePichartData($param);
    
        $blogs = app('common')->publicProfileBlog($param);

        $offers_status_dashboard = app('dashboard')->offerStatus($param);

        $deal_disputes_dashboard  = app('dashboard')->dealDisputesStatus($param);
        $average_discount = app('dashboard')->averageDiscount($param);
    
        $data['currency_symblos'] = $currency_symblos;
        // $data['mi_operations_dashboard'] = $mi_operations_dashboard;
        $data['deal_disputes_dashboard'] = $deal_disputes_dashboard;
        $data['offers_status_dashboard'] = $offers_status_dashboard;
        $data['operations_status_dashboard'] = $operations_status_dashboard;
        $data['average_retention'] = $average_retention;
        $data['average_operation_values'] = $average_operation_values;
        $data['average_rating_days'] = $average_rating_days;
        $data['average_discount'] = $average_discount;
        $data['pichart_data'] = $pichart_data ? $pichart_data['data'] : [];
        $data['pichart_labels'] = $pichart_data ? $pichart_data['labels'] : [];
        $data['user'] = $user;
        $data['blogs'] = $blogs;
        
        return view('user-profile.public-profile-seller', $data);
    }

    public function publicProfilePayer(Request $request, $slug = null)
    {
        $issuer = Issuer::where('slug', $slug)
            ->with([
            'city:id,name',
            'issuers_attach_images:id,slug,issuers_id,path,extension', 
            // 'country:id,name', 
            'favorites' => function($qry) {
                $qry->where('user_id', Auth()->user()->id);
            },
            'ratings:id,ratingable_id,issuers_title,issuers_description,rating_number,created_by',
            'ratings.rating_by_user:id,name'
            ])->withAvg('ratings', 'rating_number')->withCount('ratings')->first();
    
        if(!$issuer) {
            return redirect('/');
        }

        $param = array();
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $param['issuer_id'] = $issuer->id;
    
        $param['page_name'] = 'company_profile';
        
        $operations_status_dashboard = app('dashboard')->operationStatus($param);

        $offers_status_dashboard = app('dashboard')->offerStatus($param);

        $deal_disputes_dashboard  = app('dashboard')->dealDisputesStatus($param);

        $average_retention = app('dashboard')->averageRetention($param);
        
        $average_amount_retention = app('dashboard')->averageAmountRetention($param);
    
        $average_issuer_rating_days = app('dashboard')->averageIssuerRatingDays($param);
        
        $average_operation_values = app('dashboard')->averageOperationValue($param);

        $average_discount = app('dashboard')->averageDiscount($param);
        
        $pichart_data = app('dashboard')->getUserProfilePichartData($param);
        
        $param['user_id'] =  Auth()->user()->id;

        $blogs = app('common')->publicProfileBlog($param);

        $data['currency_symblos'] = $currency_symblos;
        $data['offers_status_dashboard'] = $offers_status_dashboard;
        $data['deal_disputes_dashboard'] = $deal_disputes_dashboard;
        $data['operations_status_dashboard'] = $operations_status_dashboard;
        $data['average_retention'] = $average_retention;
        $data['average_amount_retention'] = $average_amount_retention;
        $data['average_operation_values'] = $average_operation_values;
        $data['average_issuer_rating_days'] = $average_issuer_rating_days;
        $data['average_discount'] = $average_discount;
        $data['pichart_data'] = $pichart_data['data'];
        $data['pichart_labels'] =  $pichart_data['labels'];
        $data['issuer'] = $issuer;
        $data['blogs'] = $blogs;
        $data['user_id'] = Auth()->user()->id;

        return view('user-profile.public-profile-company', $data);
    }

    public function ajaxEnterpriseByUserList(Request $request)
    {
        if($request->ajax())
        {
            try {
                $per_page = config('constants.PER_PAGE');
                $page = $request->input('page');

                $users = User::with('roles:id')->select('id', 'slug', 'name', 'first_name', 'last_name', 'phone_number', 'email', 'profile_image')->where('enterprise_id', Auth()->user()->id)
                    ->orderBy('id', 'desc')->paginate($per_page);
                
                $dhtml = view('user-profile.ajax.ajax-enterprise-by-userlist', [
                    'users' => $users, 
                    'current_page' => $users->currentPage(), 'last_page' => $users->lastPage(), 'has_more_pages' => $users->hasMorePages()
                ])->render();
                
                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml, 'total' => $users->count()]
                ];

            } catch (\Throwable $th) {
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

    public function ajaxEnterpriseByUserDelete(Request $request)
    {
        if($request->ajax())
        {
            try {
                $slug = $request->input('user_id'); //user_id as slug
    
                $user = User::where(['slug' => $slug, 'enterprise_id' => Auth()->user()->id])->delete();

                $message = __('User delete successfully');
                if(!$user) {
                    $message = __('User no found');
                }
                $response = [
                    'status' => true,
                    'message' => $message,
                    'data' => ['type' => 'Delete']
                ];

            } catch (\Throwable $th) {
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

    public function ajaxFavoritePrfileList(Request $request)
    {
        if($request->ajax())
        {
            try {
                $favorites = Favorite::with('favoriteable')->where('user_id', Auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(config('constants.PER_PAGE'));

                    $dhtml = view('user-profile.ajax.ajax-favorite-user-list',
                    [
                        'favorites' => $favorites,
                        'last_page' => $favorites->lastPage(),
                    ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxFavoritePrfileDelete(Request $request)
    {
        $request->validate([
            'favorite_id' => 'required',
        ]);
        
        if($request->ajax())
        {
            try {
                $is_delete_favorite = Favorite::where('user_id', Auth()->user()->id)->where('id', $request->favorite_id)->delete();
                if($is_delete_favorite) {
                    $response = [
                        'status' => true,
                        'message' => __('Deleted successfully'),
                        'data' => []
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('No record Found'),
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
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function publicProfileSellerPdfExport(Request $request)
    {
        $action = $request->action;
        $seller_slug = $request->seller_slug;

        $user = User::where('slug', $seller_slug)
        ->with('city:id,name', 'issuer:id,ruc_text_id,company_name')
        ->first();
    
        if(!$user && $action != 'pdf') {
            return redirect('/');
        }

        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $param = array();
        $param['user_id'] =  $user->id;
        $param['seller_id'] =  $user->id;
        $param['page_name'] = 'operations';
        
       /*  $mi_operations_dashboard = app('operation')->getOperationDashboardWeb($param, $pagination = false);
        
        $average_retention = app('dashboard')->averageRetention($param);

        $average_rating_days = app('dashboard')->averageRatingDays($param);
        $average_operation_values = app('dashboard')->averageOperationValue($param);
        $data['average_operation_values'] = $average_operation_values;
        $data['average_rating_days'] = $average_rating_days;
        $data['currency_symblos'] = $currency_symblos;
        $data['mi_operations_dashboard'] = $mi_operations_dashboard;
        $data['average_retention'] = $average_retention;
        $data['user'] = $user; */

        $operations_status_dashboard = app('dashboard')->operationStatus($param);

        $average_retention = app('dashboard')->averageRetention($param);

        $average_operation_values = app('dashboard')->averageOperationValue($param);

        $average_rating_days = app('dashboard')->averageRatingDays($param);


        $offers_status_dashboard = app('dashboard')->offerStatus($param);

        $deal_disputes_dashboard  = app('dashboard')->dealDisputesStatus($param);

        $average_discount = app('dashboard')->averageDiscount($param);
    
        $data['currency_symblos'] = $currency_symblos;
        $data['deal_disputes_dashboard'] = $deal_disputes_dashboard;
        $data['offers_status_dashboard'] = $offers_status_dashboard;
        $data['operations_status_dashboard'] = $operations_status_dashboard;
        $data['average_retention'] = $average_retention;
        $data['average_operation_values'] = $average_operation_values;
        $data['average_rating_days'] = $average_rating_days;
        $data['average_discount'] = $average_discount;
        $data['user'] = $user;
        
        $pdf = Pdf::loadView('user-profile.pdf.seller-profile-pdf', $data);

        return $pdf->download();
    }

    public function publicProfilePayerPdfExport(Request $request)
    {   
        $action = $request->action;
        $company_slug = $request->company_slug;

        $issuer = Issuer::where('slug', $company_slug)
            ->with([
            'city:id,name',
            'issuers_attach_images:id,slug,issuers_id,path,extension', 
            ])->first();

        if(!$issuer && $action != 'pdf') {
            return redirect('/');
        }

        $param = array();
        $currency_symblos = config('constants.CURRENCY_SYMBOLS');
        $param['issuer_id'] = $issuer->id;
        $param['page_name'] = 'company_profile';
        
       /*  $operations_status_dashboard = app('dashboard')->operationStatus($param);

        $average_retention = app('dashboard')->averageRetention($param);

        $average_amount_retention = app('dashboard')->averageAmountRetention($param);

        $average_issuer_rating_days = app('dashboard')->averageIssuerRatingDays($param);

        $offers_status_dashboard = app('dashboard')->offerStatus($param);
    
        $data['currency_symblos'] = $currency_symblos;
        $data['issuer'] = $issuer;
        $data['offers_status_dashboard'] = $offers_status_dashboard;
        $data['operations_status_dashboard'] = $operations_status_dashboard;
        $data['average_retention'] = $average_retention;
        $data['average_amount_retention'] = $average_amount_retention;
        $data['average_issuer_rating_days'] = $average_issuer_rating_days;
        $data['user_id'] = Auth()->user()->id; */


        $operations_status_dashboard = app('dashboard')->operationStatus($param);

        $offers_status_dashboard = app('dashboard')->offerStatus($param);

        $deal_disputes_dashboard  = app('dashboard')->dealDisputesStatus($param);

        $average_retention = app('dashboard')->averageRetention($param);
        
        $average_amount_retention = app('dashboard')->averageAmountRetention($param);
    
        $average_issuer_rating_days = app('dashboard')->averageIssuerRatingDays($param);
        
        $average_operation_values = app('dashboard')->averageOperationValue($param);

        $average_discount = app('dashboard')->averageDiscount($param);

        $data['currency_symblos'] = $currency_symblos;
        $data['offers_status_dashboard'] = $offers_status_dashboard;
        $data['deal_disputes_dashboard'] = $deal_disputes_dashboard;
        $data['operations_status_dashboard'] = $operations_status_dashboard;
        $data['average_retention'] = $average_retention;
        $data['average_amount_retention'] = $average_amount_retention;
        $data['average_operation_values'] = $average_operation_values;
        $data['average_issuer_rating_days'] = $average_issuer_rating_days;
        $data['average_discount'] = $average_discount;
     
        $data['issuer'] = $issuer;
        $data['user_id'] = Auth()->user()->id;


        $file_path = "/user/company-profile/pdf/";

        $pdf_file_name = time()."public-company-profile.pdf";
        
        $pdf = Pdf::loadView('user-profile.pdf.company-profile-pdf', $data);

        return $pdf->download();

        /* $file_full_path = storage_path('app'.$file_path.$pdf_file_name);
        
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        
        $content = $pdf->download()->getOriginalContent();

        Storage::put($file_path.$pdf_file_name, $content);

       return response()->download($file_full_path, $pdf_file_name, $headers)->deleteFileAfterSend(false);; */

    }

    public function ajaxOtpVerifyUserAddress(Request $request)
    {
        $request->validate([
            'address_verify_otp' => 'required',
        ]);

        if($request->ajax())
        {
            DB::beginTransaction();
            try {

                $seller_slug = $request->seller_slug;
                $address_verify_otp = $request->address_verify_otp;
                if(is_array($address_verify_otp) && isset($address_verify_otp)){
                    $address_verify_otp = implode("",$request->address_verify_otp);
                }
            
                $user = User::where('id', Auth()->user()->id)->where('address_verify_otp', $address_verify_otp)->first();
                if($user)
                {
                    $user->address_verify_otp = null;
                    $user->address_verify = 'Yes';
                    $user->address_verify_at = date('Y-m-d H:i:s');
                    $user->save();
                    
                    $emails_cc = app('common')->sendEmailCC();
                    $emails_bcc = app('common')->sendEmailBCC();
                    
                    Mail::to($user->email)
                    ->when($emails_cc, function($cc_send) use ($emails_cc){
                        $cc_send->cc($emails_cc);
                    })
                    ->when($emails_bcc, function($bcc_send) use ($emails_bcc){
                        $bcc_send->bcc($emails_bcc);
                    })
                    ->send(new MailVerifyAddressSuccess($user->name));

                    DB::commit();
                    $response = [
                        'status' => true,
                        'message' => __('OTP verify successfully'),
                        'data' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('Your OTP is wrong'),
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

    public function ajaxSaveUpdateUserBank(Request $request)
    {   
        $bank_id = $request->input('bank_id') ?? '';
        $user_id = Auth()->user()->id;

        if ($request->input('preferred_payment_method') === 'eWallet') {
            $request->validate([
                'preferred_payment_method' => 'required|in:Bank,Cash,eWallet,Other',
                /*  'phone_company' => 'required|unique:bank_details,phone_company,'.$bank_id.',user_id,'.$user_id,
                'phone_number' => 'required|unique:bank_details,phone_number,'.$bank_id, */
                'phone_company' => 'required|integer',
                'phone_number' => 'required|integer',
                'identification_id' => 'required',
                // 'identification_id' => 'required|unique:bank_details,identification_id,'.$bank_id,
                'action' => 'required|in:Add,Update',
            ]);
        } else if ($request->input('preferred_payment_method') === 'Bank') {
            $request->validate([
                'preferred_payment_method' => 'required|in:Bank,Cash,eWallet,Other',
                'bank_name' => 'required',
                'account_name' => 'required',
                'account_number' => 'required',
                // 'account_number' => 'required|unique:bank_details,account_number,'.$bank_id,
                'identification_id' => 'required',
                /*  
                'identification_id' => 'required|unique:bank_details,identification_id,'.$bank_id, */
                'action' => 'required|in:Add,Update',
            ]);
        } else {
            $request->validate([
                'preferred_payment_method' => 'required|in:Bank,Cash,eWallet,Other',
                'payment_note' => 'required',
                'action' => 'required|in:Add,Update',
            ]);
        }

        if($request->ajax())
        {
            DB::beginTransaction();
            try {

                $user = User::where('id', Auth()->user()->id)->first();
                
                if($user && $user->id > 0)
                {
                    $bank_save = BankDetails::where('user_id', Auth()->user()->id)->where('id', $bank_id)->first();
                    $msg = "Bank detail updated successfully";
                    
                    if(is_null($bank_save)){
                        $bank_save = new BankDetails;
                        $msg = "Bank detail added successfully";
                    }

                    if ($request->input('preferred_payment_method') === 'eWallet') {
                        $bank_save->phone_company = $request->input('phone_company');
                        $bank_save->phone_number = $request->input('phone_number');
                        $bank_save->identification_id = $request->input('identification_id');
                        $bank_save->bank_id = null;
                        $bank_save->account_name = null;
                        $bank_save->account_number = null;

                    } else if ($request->input('preferred_payment_method') === 'Bank') {
                        $bank_save->bank_id = $request->input('bank_name');
                        $bank_save->account_name = $request->input('account_name');
                        $bank_save->account_number = $request->input('account_number');
                        $bank_save->identification_id = $request->input('identification_id');
                        $bank_save->phone_company = null;
                        $bank_save->phone_number = null;
                    } else {
                        $bank_save->phone_company = null;
                        $bank_save->phone_number = null;
                        $bank_save->bank_id = null;
                        $bank_save->account_name = null;
                        $bank_save->account_number = null;
                        $bank_save->identification_id = null;
                    }
                    
                    $bank_save->user_id  = $user->id;
                    $bank_save->payment_options = $request->input('preferred_payment_method');
                    $bank_save->payment_note = $request->input('payment_note');
                    $bank_save->save();

                    app('common')->addLogs($msg, Auth()->user()->id);
                    DB::commit();
                    $response = [
                        'status' => true,
                        'message' => __($msg),
                        'data' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => __('Something went wrong please try again!'),
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

    public function ajaxUserBankList(Request $request)
    {
        if($request->ajax())
        {
            try {
                    $banks_data = BankDetails::where('user_id', Auth()->user()->id)->whereNotIn('payment_options', ['Cash','Other'])->orderBy('id', 'desc')->paginate(50);
                    $dhtml = view('user-profile.ajax.ajax-bank-user-list',
                    [
                        'banks' => $banks_data,
                    ])->render();

                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml, 'total' => $banks_data->count()]
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() .' Line No  :'. $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'Page not found!');
        }
    }

    public function ajaxUserBankDelete(Request $request)
    {
        $request->validate([
            'bank_id' => 'required',
        ]);

        if($request->ajax())
        {
            try {

                $bank_id = $request->input('bank_id'); 
        
                $is_bank =  BankDetails::where('user_id', Auth()->user()->id)->where('id', $bank_id)->delete();

                $message = __('Bank deleted successfully');
                if(!$is_bank) {
                    $message = __('No bank found');
                }

                app('common')->addLogs($message,  Auth()->user()->id);
                
                $response = [
                    'status' => true,
                    'message' => $message,
                    'data' => ['type' => 'Delete']
                ];

            } catch (\Throwable $th) {
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
    public function ajaxGetRoleModal(){
        //Get permission list
        $permissions = Permission::whereNull('parent_id')
                    ->where('is_for_user',1)
                    ->with('childrenPermissions')
                    ->get();
        $view = view('user-profile.modal.role-modal',compact('permissions'))->render();
        return response()->json([
            'status' => true,
            'view' => $view
        ]);
    }
    public function ajaxStoreRole(Request $request){
        if($request->ajax())
        {
            try {
                $request->validate([
                    'name' => ['required', 'string', 'max:255', 'unique:roles,display_name'],
                    'description' => ['nullable', 'string'],
                ]);

                $role = Role::create([
                    'display_name' => $request->input('name'),
                    'name' => strtolower(str_replace(' ', '-', $request->input('name'))),
                    'description' => $request->input('description'),
                ]);
                if($request->input('permissions') && count($request->input('permissions')) > 0){
                    $role->attachPermissions($request->input('permissions') ?? []);
                }

                $response = [
                    'status' => true,
                    'message' => __('Role created successfully'),
                    'data' => []
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        }
    }
    public function ajaxByRoleList(Request $request)
    {
        if($request->ajax())
        {
            try {
                $per_page = config('constants.PER_PAGE');
                $page = $request->input('page');

                $roles = Role::where('created_by', Auth()->user()->id)
                    ->orderBy('id', 'desc')->paginate($per_page);
                
                $dhtml = view('user-profile.ajax.ajax-role-list', [
                    'roles' => $roles, 
                    'current_page' => $roles->currentPage(), 'last_page' => $roles->lastPage(), 'has_more_pages' => $roles->hasMorePages()
                ])->render();
                $response = [
                    'status' => true,
                    'message' => '',
                    'data' => ['dhtml' => $dhtml]
                ];

            } catch (\Throwable $th) {
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
    public function ajaxEditRole($id){
        //Get permission list
        $permissions = Permission::whereNull('parent_id')
                    ->where('is_for_user',1)
                    ->with('childrenPermissions')
                    ->get();
        $role = Role::findorfail($id);
        $roleAssignPermission = $role->permissions()->get()->pluck('id')->toArray();  

        $view = view('user-profile.modal.role-edit-modal',[
            'role' => $role,
            'permissions' => $permissions,
            'roleAssignPermission' => $roleAssignPermission,
        ])->render();

        return response()->json([
            'status' => true,
            'view' => $view
        ]);
    }
    public function ajaxUpdateRole(Request $request,$id){
        if($request->ajax())
        {
            try {
                $role = Role::findorfail($id);
                $request->validate([
                    'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'display_name')->ignore($role)],
                    'description' => ['nullable', 'string'],
                    'permissions' => ['sometimes', 'nullable', 'array'],
                    'permissions.*' => ['required', 'numeric', 'integer'],
                ]);
                $role->display_name = $request->input('name');
                $role->name = strtolower(str_replace(' ', '-', $request->input('name')));
                $role->description = $request->input('description');
                $role->is_active = $request->has('is_active') ? 1 : 0;
                $role->save();
        
                if($request->input('permissions') && count($request->input('permissions')) > 0){
                    $role->syncPermissions($request->input('permissions') ?? []);
                }

                $response = [
                    'status' => true,
                    'message' => __('Role updated successfully'),
                    'data' => []
                ];
            } catch (\Throwable $th) {
                $response = [
                    'status' => false,
                    'message' => $th->getMessage() . ' Line No  :' . $th->getLine(),
                    'data' => []
                ];
            }
            return response()->json($response);
        }
    }
    public function ajaxUserRoleDelete(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
        ]);
        if($request->ajax())
        {
            try {
                $role_id = $request->input('role_id');         
                $is_role =  Role::where('created_by', Auth()->user()->id)->where('id', $role_id)->delete();
                $message = __('Role delete successfully');
                if(!$is_role) {
                    $message = __('No role found');
                }
                app('common')->addLogs($message,  Auth()->user()->id);                
                $response = [
                    'status' => true,
                    'message' => $message,
                    'data' => ['type' => 'Delete']
                ];
            } catch (\Throwable $th) {
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
