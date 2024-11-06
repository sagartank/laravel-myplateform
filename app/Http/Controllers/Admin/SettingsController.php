<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteAdminToUser;

class SettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:settings|setting-language', ['only' => ['index','show']]);
        $this->middleware('permission:setting-language', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Settings::first();
        return view('admin.settings.create', ['edit' => $result]);
    }

    public function update(Request $request, Settings $setting)
    {
        $update_req = $request->only(['account_selection_en', 'account_selection_es', 'bank_details', 'gs_amount']);
      
        $update = Settings::where('slug', $setting->slug)->update($update_req);

      /*   $request->validate([
            'day_hour' => ['required', 'numeric', 'integer'],
            'mipo_commission' => ['required', 'numeric', 'integer'],
            'mipo_payment_commission' => ['required', 'numeric', 'integer'],
        ]);

        $update_req = $request->only(['day_hour', 'mipo_commission', 'mipo_payment_commission']);
        
        $update = Settings::where('slug', $setting->slug)->update($update_req); */

        return redirect()->route('admin.settings.index')->with('success', 'Settings Updated successfully.');
    }

    public function invite(Request $request)
    {
    
        return view('admin.settings.invite');
    }


    public function sendInviteEmail(Request $request)
    {
        $request->validate([
            'email_tos' => ['required'],
            'email_template' => ['required'],
        ]);
    
        $cc = config('constants.CC');
        $is_send_cc = $cc['SEND'];
        $emails_cc = collect($cc['EMAILS'])->where('send', true)->pluck('email')->toArray();

        $bcc = config('constants.BCC');
        $is_send_bcc = $bcc['SEND'];
        $emails_bcc = collect($bcc['EMAILS'])->where('send', true)->pluck('email')->toArray();


        $email_tos = $request->input('email_tos');
        $email_template = $request->input('email_template');

        Mail::to($email_tos)
        ->when($is_send_cc, function($cc_send) use ($emails_cc){
            $cc_send->cc($emails_cc);
        })
        ->when($is_send_bcc, function($bcc_send) use ($emails_bcc){
            $bcc_send->bcc($emails_bcc);
        })
        ->send(new InviteAdminToUser(Auth()->user()->name, $email_template));

        return redirect()->route('admin.settings.invite')->with('success', __('Email send successfully'));
    }
    
}
