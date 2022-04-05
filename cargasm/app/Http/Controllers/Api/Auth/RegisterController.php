<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\Traits\CheckLoginType;
use App\Http\Controllers\Api\Auth\Traits\RegistersUsers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\UniqueUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use CheckLoginType;
    use RegistersUsers;

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => check_login_type($data['login'])
                ? ['required', 'string', 'email', 'max:255', new UniqueUser('email')]
                : ['required', 'string', 'min:10', new UniqueUser('phone')],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:' . User::ROLE_PARTNER . ',' . User::ROLE_USER],
            'name' => 'required|string|max:255',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            $this->username($data['login']) => $data['login'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'nickname' => stristr($data['login'], '@', true),
            'social' => [
                'ok' => '',
                'vk' => '',
                'youtube' => '',
                'facebook' => '',
            ],
            'privacy' => [
                'fio' => 'true',
                'phone' => 'true',
                'email' => 'true',
                'social' => 'true',
            ],
        ]);
    }
}
