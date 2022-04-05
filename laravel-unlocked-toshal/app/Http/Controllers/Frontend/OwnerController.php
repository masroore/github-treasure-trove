<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;

class OwnerController extends Controller
{
    /*
    Method Name:    index
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        To display dashboard for user after login
    Params:         []
    */
    public function index()
    {
        $users_details = UserDetails::where('user_id', Auth::user()->id)
            ->first();
        if ($users_details != null) { //if exist
            Session::put('userdetails', $users_details);
        }
        $userDetail = User::with('user_detail')->find(Auth::user()->id);
        if (!$userDetail) {
            return redirect()->route('logout');
        }

        return view('owner.dashboard', compact('userDetail'));
    }
    // End Method index
}
