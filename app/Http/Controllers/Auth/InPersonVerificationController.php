<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\IdProofDocuments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\IpvVerificationPending as  NotificationAdminIpvVerificationPending;
use App\Notifications\UserAcceptedRejected as  NotificationAdminUserAcceptedRejected;

class InPersonVerificationController extends Controller
{
    public function create(Request $request)
    {
        /* $str = "0123456789QWERTYUIOPASDFGHJKLZXCVBNM";
        $randomCode = substr(str_shuffle($str), 0, 6);

        $user = Auth()->user();
        $user->ipv_code = $randomCode;
        $user->save(); */

        return view('auth.verify-in-person', [
            'randomCode' => '',
        ]);
    }

    public function store(Request $request)
    {
        // Define custom attribute names
        $customAttributes = [
            'id_proof_image_front' => __('Upload Photo of the Front of the Document'),
            'id_proof_image_backend' => __('Upload Photo of the Back of the Document'),
        ];

        $request->validate([
            'id_proof_image_front' => ['required',  'array'],
            'id_proof_image_front.*' => ['required','file'],
            // 'id_proof_image_front.*' => ['required','file', 'mimetypes:image/*'],
            'id_proof_image_backend' => ['required',  'array'],
            'id_proof_image_backend.*' => ['required','file'],
            // 'id_proof_image_backend.*' => ['required','file', 'mimetypes:image/*'],
        ],[], $customAttributes);
            // Set custom attribute names
        
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');
        
        DB::beginTransaction();
        try {
            $user = Auth()->user();
            if ($request->hasFile('id_proof_image_front')) {
                foreach ($request->file('id_proof_image_front') as $id_proof_image) {
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
                    DB::commit();
                }
            }

            if ($request->hasFile('id_proof_image_backend')) {
                foreach ($request->file('id_proof_image_backend') as $id_proof_image) {
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
                    DB::commit();
                }
            }
            
            if (request()->has('ipv_image') && null !== $request->input('ipv_image')) {
                $imageParts = explode(";base64,", $request->input('ipv_image'));

                $imageMimeType = $imageParts[0];

                $image = base64_decode($imageParts[1]);

                $imageExt = explode("image/", $imageMimeType);

                $fileName = uniqid() . '.' . $imageExt[1];

                Storage::put('userdata/' . $user->id . '/ipv/' . $fileName, $image);
                $user->ipv_image = 'userdata/' . $user->id . '/ipv/' . $fileName;
            }
            
            $user->registration_step = 3;
            $user->ipv_code = date('ymdhi');
            $user->save();

            if($is_send_admin_notification == true) {
                $admin_obj = app('common')->getUserDetailsRoleBy(1);
                Notification::send($admin_obj, new NotificationAdminIpvVerificationPending($user));
            }

            app('common')->addLogs('Sign up to your IPV Verification');

            DB::commit();
            //return redirect()->route('user.congratulations');
            return redirect()->route('user.ipv-screen');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function ajaxGenerateRandomCode(Request $request)
    {
        $str = "0123456789QWERTYUIOPASDFGHJKLZXCVBNM";
        $randomCode = substr(str_shuffle($str), 0, 6);

        $user = Auth()->user();
        $user->ipv_code = $randomCode;
        $user->save();
        if(!empty($user->ipv_code)) {
            $response = [
                'success' => true,
                'message' => 'Random Code Generated Successfully.',
                'randomCode' => $user->ipv_code,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'something went wrong please try again later',
                'randomCode' => '',
            ];
        }
        return response()->json($response);
    }

    public function userIpvScreen(Request $request){
        return view('auth.verify-in-person-photo-screen');
    }

    public function storeIpvPhoto(Request $request)
    {
        $environment = config('app.env');
        $is_send_admin_notification = config('constants.SEND_NOTIFICATION_ADMIN');
        
        DB::beginTransaction();
        try {
            $user = Auth()->user();
            
            if (request()->has('ipv_image') && null !== $request->input('ipv_image')) {
                $imageParts = explode(";base64,", $request->input('ipv_image'));

                $imageMimeType = $imageParts[0];

                $image = base64_decode($imageParts[1]);

                $imageExt = explode("image/", $imageMimeType);

                $fileName = uniqid() . '.' . $imageExt[1];

                Storage::put('userdata/' . $user->id . '/ipv/' . $fileName, $image);
                $user->ipv_image = 'userdata/' . $user->id . '/ipv/' . $fileName;
            }
            
            $user->registration_step = 3;
            $user->ipv_code = date('ymdhi');
            $user->registration_step_number = null;
            $user->is_registration_complete = 1;
            $user->save();
           
            if($is_send_admin_notification == true) {
                $admin_obj = app('common')->getUserDetailsRoleBy(1);
                Notification::send($admin_obj, new NotificationAdminUserAcceptedRejected($user));
            }
            app('common')->addLogs('Sign up to your IPV Verification');

            DB::commit();
            
            return redirect()->route('user.congratulations');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }
}
