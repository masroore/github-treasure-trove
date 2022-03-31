<?php

namespace Modules\AdminRbac\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\AdminRbac\Models\AdminUserGroup;

class AdminUserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('admin_users')->truncate();

        User::truncate();

        $superAdmin = User::create([
            'first_name'=>'Admin',
            'last_name'=>'istrator',
            'email'=>'sadmin@gmail.com',
            'username'=>'sadmin',
            'password'=> bcrypt('123456'),
            'status'=> 1,
        ]);

        $admin = User::create([
            'first_name'=>'Admin',
            'last_name'=>'istrator',
            'email'=>'admin@gmail.com',
            'username'=>'admin',
            'password'=> bcrypt('123456'),
            'status'=> 1,
        ]);

        // super admin
        AdminUserGroup::create([
            'user_id' => $superAdmin->id,
            'group_id' => 1,
        ]);

        AdminUserGroup::create([
            'user_id' => $admin->id,
            'group_id' => 2,
        ]);
    }
}
