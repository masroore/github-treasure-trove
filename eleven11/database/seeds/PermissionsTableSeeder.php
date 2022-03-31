<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'company_create',
            ],
            [
                'id'    => 18,
                'title' => 'company_edit',
            ],
            [
                'id'    => 19,
                'title' => 'company_show',
            ],
            [
                'id'    => 20,
                'title' => 'company_delete',
            ],
            [
                'id'    => 21,
                'title' => 'company_access',
            ],
            [
                'id'    => 22,
                'title' => 'time_tracking_create',
            ],
            [
                'id'    => 23,
                'title' => 'time_tracking_edit',
            ],
            [
                'id'    => 24,
                'title' => 'time_tracking_show',
            ],
            [
                'id'    => 25,
                'title' => 'time_tracking_delete',
            ],
            [
                'id'    => 26,
                'title' => 'time_tracking_access',
            ],
            [
                'id'    => 27,
                'title' => 'location_create',
            ],
            [
                'id'    => 28,
                'title' => 'location_edit',
            ],
            [
                'id'    => 29,
                'title' => 'location_show',
            ],
            [
                'id'    => 30,
                'title' => 'location_delete',
            ],
            [
                'id'    => 31,
                'title' => 'location_access',
            ],
            [
                'id'    => 32,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 33,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 34,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 35,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 36,
                'title' => 'random_code_create',
            ],
            [
                'id'    => 37,
                'title' => 'random_code_edit',
            ],
            [
                'id'    => 38,
                'title' => 'random_code_show',
            ],
            [
                'id'    => 39,
                'title' => 'random_code_delete',
            ],
            [
                'id'    => 40,
                'title' => 'random_code_access',
            ],
            [
                'id'    => 41,
                'title' => 'shift_create',
            ],
            [
                'id'    => 42,
                'title' => 'shift_edit',
            ],
            [
                'id'    => 43,
                'title' => 'shift_show',
            ],
            [
                'id'    => 44,
                'title' => 'shift_delete',
            ],
            [
                'id'    => 45,
                'title' => 'shift_access',
            ],
            [
                'id'    => 46,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
