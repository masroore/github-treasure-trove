<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'mail@treenga.com';
        $user->password = bcrypt('admin');
        $user->status = User::STATUS_ACTIVE;
        $user->role = User::ADMIN_ROLE;
        $user->save();
    }
}
