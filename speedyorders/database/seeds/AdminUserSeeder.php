<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('admin_users')->truncate();

        User::insert([
            [
                'username' => 'admin',
                'first_name' => 'Binay',
                'middle_name' => 'Thapa',
                'last_name' => 'Magar',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'status' => 1,

            ],
        ]);
    }
}
