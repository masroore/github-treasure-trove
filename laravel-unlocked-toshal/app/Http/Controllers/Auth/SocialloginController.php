<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Exception;
use Socialite;

class SocialloginController extends Controller
{
    //social login with google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                return redirect('/home');
            }
            $newUser = User::create([
                'first_name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => encrypt('123456dummy'),
            ]);

            Auth::login($newUser);

            return redirect('/home');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    //Social login with facebook

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);

                return redirect('/home');
            }
            $newUser = User::create([
                'first_name' => $user->name,
                'email' => $user->email,
                'facebook_id' => $user->id,
                'password' => encrypt('123456dummy'),
            ]);
            Auth::login($newUser);

            return redirect()->back();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
    }
}
