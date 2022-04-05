<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@admin.com',
            'admin' => 1,
            'password' => bcrypt('admin123'),
        ]);
    }
}
