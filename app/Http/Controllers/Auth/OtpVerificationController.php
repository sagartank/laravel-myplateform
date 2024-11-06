<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class OtpVerificationController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.verify-otp');
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp' => ['required_array_keys:0,1,2,3,4,5'],
            'otp.*' => ['required', 'numeric', 'integer'],
        ]);

        $otp = implode('', $request->input('otp'));

        $user = User::where('phone_number', Auth()->user()->phone_number)->where('otp', $otp)->first();

        if (!$user) {
            return redirect()->back()->with('error', __('Invalid Data'));
        } else {
            $user->is_otp_verified = true;
            $user->otp = null;
            $user->registration_step = 1;
            $user->registration_step_number = 'USER_DETAILS';
            $user->save();

            app('common')->addLogs('Sign up to your verify otp');

            return redirect()->route('details.user');
        }
    }

    public function resendOtp(Request $request)
    {
        $otp = app('common')->otpGenerate();

        /* try {
            $twilioSid = env("TWILIO_SID");
            $twilioAuthToken = env("TWILIO_AUTH_TOKEN");
            $twilioNumber = env("TWILIO_NUMBER");

            $client = new Client($twilioSid, $twilioAuthToken);
            $client->messages->create(
                Auth()->user()->phone_number,
                array(
                    'from' => $twilioNumber,
                    'body' => 'Your register OTP: ' . $otp,
                )
            );
        } catch (\Throwable $th) {
            //throw $th;
        }*/

        Mail::to(Auth()->user()->email)->send(new OtpVerification($otp));

        $user = Auth()->user();
        $user->otp = $otp;
        $user->save();

        $response = [
            'success' => true,
            'message' => __('OTP resend successfully'),
            //'otp' => $otp,
        ];
        
        app('common')->addLogs('OTP resend successfully');

        return response()->json($response);
    }
}
