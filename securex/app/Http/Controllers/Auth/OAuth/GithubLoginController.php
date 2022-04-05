<?php

namespace App\Http\Controllers\Auth\OAuth;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use TechTailor\RPG\Facade\RPG;

class GithubLoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubCallback(Request $request)
    {
        try {
            $user = Socialite::driver('github')->user();

            $finduser = User::where('oauth_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                return redirect()->intended('dashboard');
            }

            $email_exists = User::where('email', $user->user)->count();

            if ($email_exists) {
                return redirect()->route('login')->with('danger', 'Email address associated with your Github account is already registered with us.');
            }

            $newUser = User::create([
                'first_name' => $user->name,
                'email' => $user->email,
                'oauth' => 'github',
                'oauth_id' => $user->id,
                'email_verified_at' => Now(),
                'support_pin' => encrypt(RPG::Generate('d', 4)),
                'is_2fa_enabled' => false,
                'access_key' => RPG::Generate('ud', 30, 1, 1),
            ]);

            Auth::login($newUser);

            return redirect()->intended('dashboard');
        } catch (Exception $e) {
            if ($e->getCode() == '401') {
                $error = $request->error_description;
            } elseif ($e->getCode() == '23000') {
                $error = 'Email address associated with your Github account is already registered with us.';
            } else {
                $error = $e->getMessage();
            }

            return redirect()->route('login')->with('danger', $error);
        }
    }
}
