<?php
/**
 * Created by PhpStorm.
 * User: fomvasss
 * Date: 14.02.19
 * Time: 21:16.
 */

namespace App\Managers;

use App\Models\User;
use Hash;

class UserManager
{
    public function create(string $name, ?string $email = null, ?string $phone = null, ?string $rawPassword = null)
    {
        $rawPassword = $rawPassword ?: str_random(8);

        $user = User::create([
            'name' => $name,
            'last_name' => null,
            'email' => $email,
            'password' => Hash::make($rawPassword),
            'phone' => $phone,
            'birthday' => null,
            'data' => [],
        ]);
        $user->assignRole('client');

        event(new \App\Events\User\Created($user, $rawPassword));

        return $user;
    }
}
