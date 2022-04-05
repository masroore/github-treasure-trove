<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\NotificationsDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $count = Notifications::get()->count();

            $data['count'] = $count;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        return view('notifications');
    }

    /**
     * get notification list.
     */
    public function getNotificationsList(Request $request): void
    {
        $page = $request->input('page');

        $page_count = config('constants.page_num');
        $skip = ($page - 1) * $page_count;

        $user = Auth::user();

        $notification_list = [];

        try {
            $notification_list = Notifications::leftjoin('ct_users_notifications_detail', 'ct_users_notifications.id', '=', 'ct_users_notifications_detail.notify_id')
                ->where('ct_users_notifications_detail.user_id', $user->id)
                ->orderby('ct_users_notifications.updated_at', 'desc')
                ->select('ct_users_notifications.*', 'ct_users_notifications_detail.status', 'ct_users_notifications_detail.user_id')
                ->skip($skip)
                ->take($page_count)->get()
                ->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($notification_list);
            exit;
        }

        echo json_encode($notification_list);
    }

    /**
     * get notification detail.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function notificationDetail($id)
    {
        $user = Auth::user();

        try {
            $notification_detail = Notifications::where('id', $id)->first();
            if (null === $notification_detail) {
                return redirect()->back()->withErrors(['failed' => trans('notifications.no_content_msg')]);
            }

            $res = NotificationsDetail::where('notify_id', $id)
                ->where('user_id', $user->id)
                ->update(['status' => config('constants.notifications_status.read')]);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors(['failed' => trans('notifications.no_content_msg')]);
        }

        $data = $notification_detail->toArray();

        return view('notificationdetail', $data);
    }
}
