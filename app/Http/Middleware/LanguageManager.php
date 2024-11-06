<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageManager
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
        if (session()->has('locale')) {
            App()->setLocale(session()->get('locale'));
        }
        elseif (Auth()->user()) {
            App()->setLocale(Auth()->user()->preferred_language);
        }

        return $next($request);
    }
}
