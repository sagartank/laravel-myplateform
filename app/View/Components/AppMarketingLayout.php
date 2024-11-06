<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\HomeText;
use App\Models\SocialMedia;

class AppMarketingLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {  
        return view('layouts.marketing.app', 
       [
        'footerText' => HomeText::first(),
        'footerSocialMedia' => SocialMedia::active()->orderBy('step_number')->get(),
        ]
        );
    }
}
