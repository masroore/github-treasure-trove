<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'manage-permission', 'create-permission', 'edit-permission', 'delete-permission',
            'manage-role', 'create-role', 'edit-role', 'delete-role', 'show-role',
            'manage-user', 'create-user', 'edit-user', 'delete-user', 'show-user',
            'manage-module', 'create-module', 'delete-module', 'show-module', 'edit-module',
            'manage-setting',
            'manage-langauge', 'create-langauge', 'delete-langauge', 'show-langauge', 'edit-langauge',
        ];

        $modules = [
            'user', 'role', 'module', 'setting', 'langauge', 'permission',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        $role = Role::create([
            'name' => 'Super Admin',
        ]);
        Role::create([
            'name' => 'Admin',
        ]);

        foreach ($permissions as $permission) {
            $per = Permission::findByName($permission);
            $role->givePermissionTo($per);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'avatar' => ('avatar.jpg'),
            'type' => 'Super Admin',
            'lang' => 'en',

        ]);

        $user->assignRole($role->id);

        foreach ($modules as $module) {
            Module::create([
                'name' => $module,
            ]);
        }
    }
}
