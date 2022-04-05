<?php

namespace Modules\AdminRbac\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminRbac\Models\AdminPermissionModule;
use Modules\AdminRbac\Models\AdminPermissionReference;

class AdminModuleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Illuminate\Support\Facades\DB::table('admin_groups')->truncate();
        \Illuminate\Support\Facades\DB::table('admin_user_groups')->truncate();
        \Illuminate\Support\Facades\DB::table('admin_permission_modules')->truncate();
        \Illuminate\Support\Facades\DB::table('admin_permission_references')->truncate();
        \Illuminate\Support\Facades\DB::table('admin_permission_groups')->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $settingModules = [
            'General Setting', 'Sabre Config',
        ];

        $generalPM = AdminPermissionModule::create([
            'name' => 'Settings',
            'status' => 1,
        ]);

        foreach ($settingModules as $settingModule) {
            AdminPermissionReference::create([
                'permission_modules_id' => $generalPM->id,
                'code' => implode('-', explode(' ', strtolower($settingModule))),
                'short_desc' => $settingModule,
                'description' => $settingModule,
            ]);
        }

        $modules = [
            'Users',
            'Groups',
        ];

        $submodules = [
            'view',
            'create',
            'show',
            'edit',
            'delete',
        ];

        foreach ($modules as $module) {
            $permissionModule = AdminPermissionModule::create([
                'name' => $module,
                'status' => 1,
            ]);

            foreach ($submodules as $submodule) {
                AdminPermissionReference::create([
                    'permission_modules_id' => $permissionModule->id,
                    'code' => $submodule . '-' . strtolower($module),
                    'short_desc' => ucfirst($submodule) . ' ' . $module,
                    'description' => ucfirst($submodule) . ' ' . $module,
                ]);
            }
        }
    }
}
