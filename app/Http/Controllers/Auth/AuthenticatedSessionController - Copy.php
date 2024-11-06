<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(!session()->get('locale')) {
            App::setLocale('es');
            session()->put('locale', 'es');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        if(Auth()->user()->is_active != config('constants.IS_USER_LOGIN')) {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
        
            throw ValidationException::withMessages([
                'email' => 'you are blocked from performing this operation. please contact your administrator for help',
            ]);

            if(Auth()->user()->is_admin) {
                app('common')->addLogs('admin login');
            } else {
                app('common')->addLogs('web login');
            }
    
            return redirect()->route('login');
        }

        if (Auth()->user()->is_registered) {

            if(Auth()->user()->is_admin) {
                app('common')->addLogs('admin login');
            } else {
                app('common')->addLogs('web login');
            }
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        else{

            if(Auth()->user()->is_admin) {
                app('common')->addLogs('admin login');
            } else {
                app('common')->addLogs('web login');
                if(Auth()->user()->is_registration_complete && !Auth()->user()->is_registered){
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();            
                    $request->session()->regenerateToken();
                    return  redirect()->back()->with('error','Your account is not approved.it`s under review by administrator team.');
                }else{
                    return redirect()->intended(RouteServiceProvider::HOME);
                }
            }

            /* 
                if (Auth()->user()->registration_step == 0) {
                    return redirect()->route('verify.otp');
                }
                elseif (Auth()->user()->registration_step == 1) {
                    return redirect()->route('details.user');
                }
                elseif (Auth()->user()->registration_step == 2) {
                    return redirect()->route('verify.in-person');
                }
                elseif (Auth()->user()->registration_step == 3) {
                    return redirect()->route('details.account');
                }
                elseif (Auth()->user()->registration_step == 4 && Auth()->user()->account_type == 'Enterprise') {
                    return redirect()->route('user.plans');
                }
                elseif (Auth()->user()->registration_step == 5) {
                    return redirect()->route('landing');
                } 
            */
            
           /* if (Auth()->user()->registration_step == 0) {
                return redirect()->route('verify.otp');
            }
            elseif (Auth()->user()->registration_step == 1) {
                return redirect()->route('details.user');
            }
            elseif (Auth()->user()->registration_step == 2) {
                return redirect()->route('verify.in-person');
            }
            elseif (Auth()->user()->registration_step == 3) {
                return redirect()->route('user.congratulations');
            }
            elseif (Auth()->user()->registration_step == 4) {
                return redirect()->route('landing');
            } */
            
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        if(Auth()->user()->is_admin) {
            app('common')->addLogs('admin logout');
        } else {
            app('common')->addLogs('web logout');
        }

        $user_last_login = Auth()->user();
        $user_last_login->last_login_ip = app('common')->getUserIP();
        $user_last_login->last_login_at = Carbon::now();
        $user_last_login->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
