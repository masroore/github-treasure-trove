<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run(): void
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return 'user_' != substr($permission->title, 0, 5) && 'role_' != substr($permission->title, 0, 5) && 'permission_' != substr($permission->title, 0, 11);
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
