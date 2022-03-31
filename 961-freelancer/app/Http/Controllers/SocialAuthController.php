<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Redirect;
use Socialite;

class SocialAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    // Facebook Login
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function FacebookProviderCallback()
    {
        // $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        $user = Socialite::driver('facebook')->user();
        // dd($user);
        $checkExist = User::where('email', $user->email)->first();
        if ($checkExist) {
            if (!$checkExist->facebook_id) {
                $checkExist->facebook_id = $user->id;
                $checkExist->save();
            }
            Auth::login($checkExist);
            $user = Auth::user();
            $id = $user->id;

            return redirect('profile');
        }
        $username = $user->name;
        $username = str_replace(' ', '', $username);
        $username = strtolower($username);

        return View::make('frontend.facebook-register')->with([
          'user' => $user,
          'username' => $username,
        ]);

        // auth()->login($user);
     // return redirect()->to('/user/about');
    }

    public function facebookRegister(Request $request)
    {
        $newuser = new User();
        $newuser->email = $request->email;
        $newuser->first_name = $request->first_name;

        $newuser->username = $request->username;
        $newuser->facebook_id = $request->facebook_id;
        $newuser->user_status = 'online';
        $newuser->profile_image = $request->profile_image;
        $newuser->account_type = $request->account_type;
        $newuser->password = Hash::make(trim($request->password));
        $user->verification = 1;
        $newuser->save();
        Auth::login($newuser);

        return redirect('profile');
    }

    // Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function GoogleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();
            // dd($user->user['given_name']);
            if ($finduser) {
                Auth::login($finduser);

                return redirect('profile');
            }
            $username = $user->name;
            $username = str_replace(' ', '', $username);
            $username = strtolower($username);

            return View::make('frontend.google-register')->with([
            'user' => $user,
            'username' => $username,
          ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function googleRegister(Request $request)
    {
        $newUser = User::create([
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'username' => $request->username,
          'profile_image' => $request->profile_image,
          'google_id'=> $request->google_id,
          'password' => Hash::make(trim($request->password)),
          'user_status' => 'online',
          'account_type' => $request->account_type,
          'verification' => 1,
      ]);
        Auth::login($newUser);

        return redirect('profile');
    }
}
