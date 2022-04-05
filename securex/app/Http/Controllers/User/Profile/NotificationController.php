<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Lang;

class NotificationController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Display all user notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('main.profile.notifications')->with(compact('notifications'));
    }

    /**
     * Mark all unread notifications as read.
     */
    public function mark()
    {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);

        laraflash(Lang::get('alerts.profile.notifications_read'), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Delete / Clear all notifications for the user.
     */
    public function delete()
    {
        $user = Auth::user();
        $user->notifications()->delete();

        laraflash(Lang::get('alerts.profile.notifications_cleared'), Lang::get('alerts.success'))->success();

        return back();
    }
}
