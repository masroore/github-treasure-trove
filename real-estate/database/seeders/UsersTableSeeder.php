<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'verified'           => 1,
                'verified_at'        => '2021-08-08 21:31:57',
                'verification_token' => '',
                'phone'              => '',
                'facebook'           => '',
                'twitter'            => '',
                'instagram'          => '',
                'youtube'            => '',
                'address'            => '',
                'city'               => '',
                'country'            => '',
                'about'              => '',
                'username'           => '',
                'website'            => '',
            ],
        ];

        User::insert($users);
    }
}
