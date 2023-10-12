<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function clearNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
