<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UserRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/start';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('front.auth.register');
    }

    public function register(UserRegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => 'redirect',
                'destination' => url(app()->getLocale() . '/start'),
            ]);
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $attributes)
    {
        $password = $attributes['password'];
        $user = User::create([
            'name' => $attributes['name'],
            'last_name' => $attributes['last_name'] ?? null,
            'email' => $attributes['email'],
            'password' => Hash::make($password),

            'phone' => $attributes['phone'],
            'birthday' => $attributes['birthday'] ?? null,
            'data' => $attributes['data'] ?? [],
        ]);
        $user->assignRole('client');

        return $user;
    }
}
