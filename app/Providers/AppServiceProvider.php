<?php

namespace App\Providers;

use App\Models\HomeText;
use App\Models\SocialMedia;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use \Spatie\Activitylog\Models\Activity;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Password::defaults(function () {
            $rule = Password::min(8);
     
            return $this->app->environment('production')
                        ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                        : $rule;
        });

        View::composer([
           'layouts.marketing.footer'
        ], function ($view) {
            $view->with([
                'socialMedia' => SocialMedia::active()->select('id', 'slug', 'link', 'icon_image')->get(),
                'homeText' => HomeText::select('footer_text')->first(),
            ]);
        });

        Schema::defaultStringLength(191);

        Activity::saving(function (Activity $activity) {
            $ip = request()->ip(); //Dynamic IP address get
            $location = \Location::get($ip);
            $activity->properties = $activity->properties->put('agent', [
                'ip' => Request::ip(),
                'browser' => \Browser::browserName(),
                'user_agent' => \Browser::userAgent(),
                'os' => \Browser::platformName(),
                'url' => Request::fullUrl(),
                'device_type' => \Browser::deviceType(),
                'latitude' => $location->latitude ?? '',
                'longitude' => $location->longitude ?? ''
            ]);
        });
    }
}
