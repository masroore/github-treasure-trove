<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();
        $usercount = DB::table('users')->where('email', 'admin@gmail.com')->count();
        // Role::create(['name' => 'User']);
        // Role::create(['name' => 'Owner']);
        if ($usercount == 0) {
            $user = User::create([
                'first_name' => 'Venue',
                'last_name' => 'Booking',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('pass@admin'),
                'social_type' => 'Website',
                'social_id' => 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $role = Role::create(['name' => 'Administrator']);

            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
        }

        //create User role
        $customercount = DB::table('users')->where('email', 'customer@gmail.com')->count();
        if ($customercount == 0) {
            $customer = User::create([
                'first_name' => 'test',
                'last_name' => 'user',
                'email' => 'customer@gmail.com',
                'password' => bcrypt('123456'),
                'social_type' => 'Website',
                'social_id' => 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $role = Role::create(['name' => 'User']);

            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);

            $customer->assignRole([$role->id]);
        }

        //create Owner role
        $ownerecount = DB::table('users')->where('email', 'owner@gmail.com')->count();
        if ($ownerecount == 0) {
            $owner = User::create([
                'first_name' => 'owner',
                'last_name' => 'owner',
                'email' => 'owner@gmail.com',
                'password' => bcrypt('123456'),
                'social_type' => 'Website',
                'social_id' => 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $role = Role::create(['name' => 'Owner']);

            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);

            $owner->assignRole([$role->id]);
        }
    }
}
