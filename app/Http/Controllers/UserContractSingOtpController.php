<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserContractSing;
use App\Models\userContractSingOtp;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SignContractOtp as NotificationsSignContractOtp;

class UserContractSingOtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'deal_otp' => 'required',
            'deal_offer_id' => 'required',
        ]);

        try {
            $otp = $request->deal_otp;
            $offer_id = $request->deal_offer_id;

            $is_exits = userContractSingOtp::where('offer_id', $offer_id)->where('id', $id)->first();
            if($is_exits && ($is_exits->otp == $otp || config('constants.ALL_OTP_VERIFY') == $otp)) {
                $is_exits->is_otp_verify = 1;
                $is_exits->save();

                $response = [
                    'status' => true,
                    'message' => __('OTP verify Successfully'),
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('Your OTP is wrong'),
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function resendOTP(Request $request, $id)
    {
        $request->validate([
            'deal_offer_id' => 'required',
        ]);

        try {
            $offer_id = $request->deal_offer_id;

            $is_exits = userContractSingOtp::where('offer_id', $offer_id)->where('id', $id)->first();
            if($is_exits && $is_exits->id == $id) {

                $otp = app('common')->otpGenerate();
                
                $is_exits->otp = $otp;
                $is_exits->is_otp_verify = 0;
                $is_exits->save();

                $user_obj = app('common')->getUserEmail($is_exits->user_id);
                Notification::send($user_obj, new NotificationsSignContractOtp(app()->getLocale(), $otp, 'user contract'));

                $response = [
                    'status' => true,
                    'message' => __('OTP resend successfully'),
                    'data' => []
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => __('No record found'),
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
    }
}
