<?php

namespace Modules\AdminLogin\Http\Controllers;

use App\Models\User;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('adminlogin::index');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->get('username'))
            ->orWhere('email', $request->get('username'))
            ->first();

        if (!$user) {
            return redirect()->route('admin.login')
                ->with('error_message', 'Invalid username or password.');
        }

        if (Helper::DELETED == $user->status) {
            return redirect()
                ->route('admin.login')
                ->with('error_message', 'Invalid username or password.');
        }

        if (!Hash::check($request->get('password'), $user->password)) {
            return redirect()->route('admin.login')
                ->with('error_message', 'Invalid username or password.');
        }

        if ($user) {
            Auth::guard('admin')->loginUsingId($user->id);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')
            ->with('error_message', 'Invalid username or password.');
    }

    public function logOut()
    {
        auth('admin')->logout();

        return redirect()->route('admin.login');
    }
}
