<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
class EnsureRegistratonIsCompleteAndApprovedByAdmin
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
        if ($user->is_registration_complete){
            if($user->is_registered){
                return $next($request);
            }else{
                Auth::guard('web')->logout();
                $request->session()->invalidate();    
                $request->session()->regenerateToken();
                return redirect('/');
                //return redirect()->back()->with('error','Your account is not approved.it`s under review by administrator team.');    
            }
        } else {
            if($user && !is_null($user->registration_step_number)) {
                $route = config('constants.REGISTRATION_STEPS')[$user->registration_step_number];
                return ($route) ? redirect()->route($route) : $next($request);
            } else {
                return $next($request);
            }
        }
    }
}
