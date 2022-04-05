<?php
/**
 * Created by PhpStorm.
 * User: Lockie.J
 * Date: 10/21/2020
 * Time: 7:14 AM.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function get(Request $request)
    {
        $notifications = DB::table('notifications')->where('user_id', $request->user_id)->get();
        foreach ($notifications as $notification) {
            $notification->created_at = date('d F Y', strtotime($notification->created_at));
        }

        return json_encode($notifications);
    }
}
