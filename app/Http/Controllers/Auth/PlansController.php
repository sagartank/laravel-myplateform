<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetails;
use App\Models\Plan;
use App\Models\UserPlanSubscription;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Deviam\Bancard\Bancard;
use Illuminate\Support\Facades\Session;

class PlansController extends Controller
{
    public function create(Request $request)
    {
        $data['user'] = Auth()->user();
        $plans = Plan::where('is_active', '1')->get()->groupBy('duration');
        $data['months'] = $plans['month'] ?? [];
        $data['years'] = $plans['year'] ?? [];
        $data['user_paln'] = User::with('plan:id,name,slug')->select('id', 'name', 'plan_id', 'plan_status')->where('id',  Auth()->user()->id)->first();
        return view('auth.user-plans', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_type' => ['required', 'string'],
            'account_roles' => ['nullable', 'array'],
            'ent_business_type' => ['nullable', 'string', 'max:255'],
            'ent_no_of_users' => ['sometimes', 'nullable', 'string'],
            'ent_no_of_deals_per_day' => ['sometimes', 'nullable', 'string'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'preferred_payment_method' => ['required', 'string'],
            'preferred_currency' => ['nullable', 'string'],
            'estimated_budget' => ['nullable', 'numeric', 'integer'],
        ]);
    
        $user = Auth()->user();

        $user->account_type = $request->input('account_type');

        if ($request->input('account_type') === 'enterprise') {
            $user->ent_no_of_users = $request->input('ent_no_of_users');
            $user->ent_no_of_deals_per_day = $request->input('ent_no_of_deals_per_day');
            $user->ent_business_type = $request->input('ent_business_type');
        }

        if ($request->input('account_roles') !== null)
        foreach ($request->input('account_roles') as $key => $value) {
            if($key === 'as_borrower') {
                $user->as_borrower = true;
            }
            if($key === 'as_investor') {
                $user->as_investor = true;
            }
        }

        $user->occupation = $request->input('occupation');
        $user->bio = $request->input('bio');
        $user->estimated_budget = $request->input('estimated_budget');
        $user->preferred_payment_method = $request->input('preferred_payment_method');
        $user->preferred_currency = $request->input('preferred_currency');

        $user->registration_step = 4;
        $user->save();

        if($user->id > 0) {
            $bank_save = new BankDetails;
            if ($request->input('preferred_payment_method') === 'eWallet') {
                $bank_save->phone_company = $request->input('phone_company');
                $bank_save->phone_number = $request->input('phone_number');
                $bank_save->identification_id = $request->input('identification_id');
            } else if ($request->input('preferred_payment_method') === 'Bank') {
                $bank_save->bank_name = $request->input('bank_name');
                $bank_save->account_name = $request->input('account_name');
                $bank_save->account_number = $request->input('account_number');
                $bank_save->identification_id = $request->input('identification_id');
            }
            $bank_save->user_id  = $user->id;
            $bank_save->payment_options = $request->input('preferred_payment_method');
            $bank_save->payment_note = $request->input('payment_note');
            $bank_save->save();
        }
        
        app('common')->addLogs('Sign up to your select plan');

        return redirect()->route('landing');
    }

    public function landing(Request $request)
    {
        return view('auth.landing');
    }
    public function userPlanCheckout($slug){
        $plan = Plan::with('userLevel')->where('slug',$slug)->first();
        $user = auth()->user();
        $response = Bancard::singleBuy($plan->name, $plan->price);
        if ($response->failed()) {
            return redirect()->back()->with('error','Something went wrong!');
            
        }
        $data = $response->json();
        $processId = $data['process_id'];
        $scriptUrl = Bancard::scriptUrl();
        // return view('payment.payment-iframe', compact('processId', 'scriptUrl'));
        Session::put('selectedPlanSlug', $slug);
        return view('auth.user-plan-checkout', compact('processId', 'scriptUrl','plan','user'));
    }
    public function userPlanCheckoutOld($slug){

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

        return redirect()->route('user-plan.purchase-success',$plan->slug);
    }
    public function userPlanPurchaseSuccess($slug){
        $plan = Plan::where('slug',$slug)->first();
        return view('auth.user-plan-purchase-success',compact('plan'));
    }
}
?>
