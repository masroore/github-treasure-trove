<?php

namespace App\Http\Controllers\Back\Api1;

use App\Http\Controllers\Controller;
use App\User;
use Bouncer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $query = (new User())->newQuery();

        /*if (Bouncer::is(auth()->user())->an('editor')) {
            $query->where('client_id', auth()->user()->clientId());
        }*/

        if ($request->has('query')) {
            $query->where('name', 'like', '%' . $request->input('query') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('query') . '%');
        }

        $users = $query->groupBy('id')->get();

        return response()->json($users);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function notificationsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['status' => 200]);
    }
}
