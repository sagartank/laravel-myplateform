<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index() {
        $data['notifications'] = auth::user()->unreadNotifications()->orderBy('created_at', 'desc')->get();
        // $data['notifications'] = auth()->user()->notifications()->orderBy('read_at', 'asc')->orderBy('created_at', 'desc')->get();
        return view('notifications-list', $data);  
    }

    public function notificationsAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        $response = [
            'status' => true,
            'message' => __('All notifications marked as read.'),
            'data' => []
        ];

        return response()->json($response);
    } 
}
