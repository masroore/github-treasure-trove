<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function markallasread(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
        echo 'Notification Marked as Read';
    }

    public function DeleteAllNotifications(): void
    {
        auth()->user()->notifications()->delete();
        echo 'Notification Deleted Successfully!';
    }
}
