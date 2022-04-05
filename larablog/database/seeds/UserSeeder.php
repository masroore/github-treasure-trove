<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@admin.com',
            'email_verified_at' => Carbon\Carbon::now(),
            'role_id' => 1,
            'password' => Hash::make('superadmin@admin.com'),
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon\Carbon::now(),
            'role_id' => 2,
            'password' => Hash::make('admin@admin.com'),
        ]);
        User::create([
            'name' => 'Author',
            'email' => 'author@author.com',
            'email_verified_at' => Carbon\Carbon::now(),
            'role_id' => 3,
            'password' => Hash::make('author@author.com'),
        ]);
    }
}
