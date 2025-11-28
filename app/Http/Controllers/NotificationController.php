<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = Auth::user()->unreadNotifications->find($id);

        if ($notification) {
            // Mark as read
            $notification->markAsRead();

            // Redirect safely
            return redirect($notification->data['url'] ?? '/');
        }

    }
}

