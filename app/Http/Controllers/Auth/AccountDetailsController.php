<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetails;
use App\Models\IssuerBank;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SignsUpAsInvestor as NotificationSignsUpAsInvestor;
use App\Notifications\SignsUpAsBorrower as NotificationSignsUpAsBorrower;

class AccountDetailsController extends Controller
{
    public function create(Request $request)
    {
        $data['user'] = Auth()->user();
        $data['banks']  = IssuerBank::select('id', 'name')->orderBy('name', 'asc')->get();      
        
        return view('auth.account-details', $data);
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
                $user_obj = app('common')->getUserEmail($user->id);
                Notification::send($user_obj, new NotificationSignsUpAsBorrower(app()->getLocale()));
                app('common')->addLogs('send email user borrower', $user_obj->id);
            }
            if($key === 'as_investor') {
                $user->as_investor = true;
                $user_obj = app('common')->getUserEmail($user->id);
                Notification::send($user_obj, new NotificationSignsUpAsInvestor(app()->getLocale()));
                app('common')->addLogs('send email user investor', $user_obj->id);
            }
        }

        $user->occupation = $request->input('occupation');
        $user->bio = $request->input('bio');
        $user->estimated_budget = $request->input('estimated_budget');
        $user->preferred_payment_method = $request->input('preferred_payment_method');
        $user->preferred_currency = $request->input('preferred_currency');

        $user->registration_step = 4;
        $user->save();
        
        app('common')->addLogs('Sign up to your Account Selection like Individual / Enterprise');

        if($user->id > 0) {
            $bank_save = new BankDetails;
            if ($request->input('preferred_payment_method') === 'eWallet') {
                $bank_save->phone_company = $request->input('phone_company');
                $bank_save->phone_number = $request->input('phone_number');
                $bank_save->identification_id = $request->input('identification_id');
            } else if ($request->input('preferred_payment_method') === 'Bank') {
                $bank_save->bank_id = $request->input('bank_name');
                $bank_save->account_name = $request->input('account_name');
                $bank_save->account_number = $request->input('account_number');
                $bank_save->identification_id = $request->input('identification_id');
            }
            $bank_save->user_id  = $user->id;
            $bank_save->payment_options = $request->input('preferred_payment_method');
            $bank_save->payment_note = $request->input('payment_note');
            $bank_save->save();
        }

        if ($request->input('account_type') === 'enterprise') {
            return redirect()->route('user.plans');
        } else {
            return redirect()->route('landing');
        }
    }

    public function landing(Request $request)
    {
        return view('auth.landing');
    }
}
?>
