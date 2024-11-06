<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
class RegistrationRoutesPrevention
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user && $user->is_registration_complete){
            return redirect()->intended(RouteServiceProvider::HOME);
        }else{
            return $next($request);
        }
        /*elseif(!$user->is_registration_complete){
            dd($user);
            if($user->registration_step_number) {
                return redirect()->intended('/');
                //return redirect('/');
                // $currentRouteName = $request->route()->getName();
                // if($currentRouteName == 'verify.otp' && config('constants.REGISTRATION_STEPS')[$user->registration_step_number] == 'verify.otp'){
                //     return redirect()->route('verify.otp');
                // }elseif($currentRouteName == 'details.user' && config('constants.REGISTRATION_STEPS')[$user->registration_step_number] == 'details.user'){
                //     dd('@28');
                //     return redirect()->route('details.user');
                // }elseif($currentRouteName == 'verify.in-person' && config('constants.REGISTRATION_STEPS')[$user->registration_step_number] == 'verify.in-person'){
                //     return redirect()->route('verify.in-person');
                // }else{
                //     dd($currentRouteName,32,$user->registration_step_number);
                // }
                //$route = config('constants.REGISTRATION_STEPS')[$user->registration_step_number];
                //return ($route) ? redirect()->route($route) : $next($request);
            } else {
                return $next($request);
            }
        }*/
        //return $next($request);
    }
}
