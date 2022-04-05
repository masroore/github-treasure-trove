<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@si-aldo.com',
                'password' => bcrypt('12345678'),
                'remember_token' => null,
                'approved' => 1,
                'username' => 'admin',
                'phone' => '087755230371',
            ],
            [
                'id' => 2,
                'name' => 'KI',
                'email' => 'konsultan@si-aldo.com',
                'password' => bcrypt('12345678'),
                'remember_token' => null,
                'approved' => 1,
                'username' => 'yogi',
                'phone' => '085821343090',
            ],
        ];

        User::insert($users);
    }
}
