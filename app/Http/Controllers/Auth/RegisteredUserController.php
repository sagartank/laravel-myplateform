<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerification;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Twilio\Rest\Client;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Role;
use App\Models\UserPlanSubscription;
use App\Models\InviteFriends;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {   
        $email = $readonly = $ref_token = "";

        if($request->has('ref')) {
            $ref_token = $request->get('ref');
            $is_ref = InviteFriends::where('invitation_token', $ref_token)->where('is_verify', 'No')->first();
            if($is_ref && !empty($is_ref->email)) {
                $email = $is_ref->email;
                $readonly = 'readonly';
                $ref_token = $ref_token;
            } else {
                $ref_token = '';
                return redirect()->route('register');
            }
        }

        $data['email'] = $email;
        $data['readonly'] = $readonly;
        $data['ref_token'] = $ref_token;

        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $ref_token = $request->get('ref_token');
        $referrer_id = null;

        $request->validate([
            //            'name' => ['required', 'string', 'max:255'],
            'agree' => ['required'],
            'is_referral_code' => ['nullable', 'sometimes'],
            'referral_code' => ['required_if:is_referral_code,1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/', 'max:15', 'min:10'],
            'password' => ['required', 'confirmed', 'max:15', 'min:8', "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+/"],
            // 'phone_number' => ['required', 'string', 'regex:/^([0-9\ \-\+\(\)]*)$/', 'max:255', 'unique:users'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults(), 'max:15', 'min:8'],
        ],[
            'password.regex' => __('The password must contain at least one lowercase letter, one uppercase letter, and one digit'),
        ]);
        
        DB::beginTransaction();
        try {
            $otp = app('common')->otpGenerate();
            
            if($request->has('is_referral_code') && $request->has('referral_code')) {
                $is_referrer = InviteFriends::where('referral_code', $request->get('referral_code'))->where('is_verify', 'No')->first();
            } else {
                $is_referrer = InviteFriends::where('invitation_token', $ref_token)->where('is_verify', 'No')->first();
            }
        
            if($is_referrer) {
                $referrer_id = $is_referrer->user_id;
                $is_referrer->is_verify = 'Yes';
                $is_referrer->save();
                app('common')->addLogs('Sign up to your account with referrer code');
            }

            $user = User::create([
                // 'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'otp' => $otp,
                'is_admin' => 0,
                'registration_step_number' => 'OPT_VERIFY',
                'referrer_id' => $referrer_id,
                'account_type' => config('constants.ACCOUNT_TYPE')[1],
                'preferred_language' => "es",
                'preferred_currency' => config('constants.CURRENCY_TYPE')[1],
                'preferred_dashboard' => config('constants.PREFERRED_DASHBOARD')[1],
                'preferred_contact_method' => config('constants.PREFERRED_CONTACT_METHOD')[0],
            ]);
            
            event(new Registered($user));

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

            Auth::login($user);
            
            app('common')->addLogs('Sign up to your account');
            
            Mail::to($request->email)->send(new OtpVerification($otp));
            
            DB::commit();
            return redirect()->route('verify.otp');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
        // return redirect(RouteServiceProvider::HOME);

        /* try {
            $twilioSid = env("TWILIO_SID");
            $twilioAuthToken = env("TWILIO_AUTH_TOKEN");
            $twilioNumber = env("TWILIO_NUMBER");    

            $client = new Client($twilioSid, $twilioAuthToken);
            $client->messages->create(
                $request->phone_number,
                array(
                    'from' => $twilioNumber,
                    'body' => 'Your register OTP: ' . $otp,
                )
            );
        } catch (\Throwable $th) {
            //throw $th;
        } */
    }

    public function ajaxVerifyPassword(Request $request)
    {
        $request->validate([
            'password' => [Rules\Password::defaults()],
        ]);
    }
}
