<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notifications;

class Notification extends Component
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
        $param = array();
        $param['user_id'] =  Auth()->user()->id;
        $data['user_login_name'] =  Auth()->user()->name;
        $data['notifications'] = Auth()->user()->unreadNotifications;
        
        return view('components.notification', $data);
    }
}
