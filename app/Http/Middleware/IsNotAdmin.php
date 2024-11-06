<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsNotAdmin
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
        if (!Auth()->user()->is_admin) {
            if(Auth()->user()->account_type == config('constants.ACCOUNT_TYPE_ENTERPRISE') && Auth()->user()->is_registered == '1') {
                return $next($request);
            } else {
                return $next($request);
            }
            // if (Auth()->user()->is_registered){
            //     return $next($request);
            // } else {
            //     return redirect()->route('landing');
            // }
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
}
