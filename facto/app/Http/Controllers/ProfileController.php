<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.profile');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        // dd( $request->user()->password );
        $current_password = $request->current_password;
        // $current_password = 'dkqpsXkehfm159!?';

        if (!Hash::check($current_password, $request->user()->password)) {
            $msg = '기존 비밀번호가 올바르지 않습니다.';

            return redirect()->back()->with('error', $msg);
        }

        $this->validate($request, [
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
        ]);

        $request->user()->fill([
            'password' => Hash::make($request->password),
            'password1' => $request->password,
        ])->save();

        $msg = '변경되었습니다.';

        return redirect()->back()->with('success', $msg);
    }
}
