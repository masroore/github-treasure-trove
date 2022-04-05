<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'title' => 'user_management_access',
            ],
            [
                'id' => 2,
                'title' => 'permission_create',
            ],
            [
                'id' => 3,
                'title' => 'permission_edit',
            ],
            [
                'id' => 4,
                'title' => 'permission_show',
            ],
            [
                'id' => 5,
                'title' => 'permission_delete',
            ],
            [
                'id' => 6,
                'title' => 'permission_access',
            ],
            [
                'id' => 7,
                'title' => 'role_create',
            ],
            [
                'id' => 8,
                'title' => 'role_edit',
            ],
            [
                'id' => 9,
                'title' => 'role_show',
            ],
            [
                'id' => 10,
                'title' => 'role_delete',
            ],
            [
                'id' => 11,
                'title' => 'role_access',
            ],
            [
                'id' => 12,
                'title' => 'user_create',
            ],
            [
                'id' => 13,
                'title' => 'user_edit',
            ],
            [
                'id' => 14,
                'title' => 'user_show',
            ],
            [
                'id' => 15,
                'title' => 'user_delete',
            ],
            [
                'id' => 16,
                'title' => 'user_access',
            ],
            [
                'id' => 17,
                'title' => 'administrative_management_access',
            ],
            [
                'id' => 18,
                'title' => 'kecamatan_create',
            ],
            [
                'id' => 19,
                'title' => 'kecamatan_edit',
            ],
            [
                'id' => 20,
                'title' => 'kecamatan_show',
            ],
            [
                'id' => 21,
                'title' => 'kecamatan_delete',
            ],
            [
                'id' => 22,
                'title' => 'kecamatan_access',
            ],
            [
                'id' => 23,
                'title' => 'kelurahan_create',
            ],
            [
                'id' => 24,
                'title' => 'kelurahan_edit',
            ],
            [
                'id' => 25,
                'title' => 'kelurahan_show',
            ],
            [
                'id' => 26,
                'title' => 'kelurahan_delete',
            ],
            [
                'id' => 27,
                'title' => 'kelurahan_access',
            ],
            [
                'id' => 28,
                'title' => 'category_create',
            ],
            [
                'id' => 29,
                'title' => 'category_edit',
            ],
            [
                'id' => 30,
                'title' => 'category_show',
            ],
            [
                'id' => 31,
                'title' => 'category_delete',
            ],
            [
                'id' => 32,
                'title' => 'category_access',
            ],
            [
                'id' => 33,
                'title' => 'asset_access',
            ],
            [
                'id' => 34,
                'title' => 'build_create',
            ],
            [
                'id' => 35,
                'title' => 'build_edit',
            ],
            [
                'id' => 36,
                'title' => 'build_show',
            ],
            [
                'id' => 37,
                'title' => 'build_delete',
            ],
            [
                'id' => 38,
                'title' => 'build_access',
            ],
            [
                'id' => 39,
                'title' => 'nsup_create',
            ],
            [
                'id' => 40,
                'title' => 'nsup_edit',
            ],
            [
                'id' => 41,
                'title' => 'nsup_show',
            ],
            [
                'id' => 42,
                'title' => 'nsup_delete',
            ],
            [
                'id' => 43,
                'title' => 'nsup_access',
            ],
            [
                'id' => 44,
                'title' => 'ipal_create',
            ],
            [
                'id' => 45,
                'title' => 'ipal_edit',
            ],
            [
                'id' => 46,
                'title' => 'ipal_show',
            ],
            [
                'id' => 47,
                'title' => 'ipal_delete',
            ],
            [
                'id' => 48,
                'title' => 'ipal_access',
            ],
            [
                'id' => 49,
                'title' => 'build_gallery_create',
            ],
            [
                'id' => 50,
                'title' => 'build_gallery_edit',
            ],
            [
                'id' => 51,
                'title' => 'build_gallery_show',
            ],
            [
                'id' => 52,
                'title' => 'build_gallery_delete',
            ],
            [
                'id' => 53,
                'title' => 'build_gallery_access',
            ],
            [
                'id' => 54,
                'title' => 'data_analytic_access',
            ],
            [
                'id' => 55,
                'title' => 'density_create',
            ],
            [
                'id' => 56,
                'title' => 'density_edit',
            ],
            [
                'id' => 57,
                'title' => 'density_show',
            ],
            [
                'id' => 58,
                'title' => 'density_delete',
            ],
            [
                'id' => 59,
                'title' => 'density_access',
            ],
            [
                'id' => 60,
                'title' => 'sanitation_create',
            ],
            [
                'id' => 61,
                'title' => 'sanitation_edit',
            ],
            [
                'id' => 62,
                'title' => 'sanitation_show',
            ],
            [
                'id' => 63,
                'title' => 'sanitation_access',
            ],
            [
                'id' => 64,
                'title' => 'risk_create',
            ],
            [
                'id' => 65,
                'title' => 'risk_edit',
            ],
            [
                'id' => 66,
                'title' => 'risk_access',
            ],
            [
                'id' => 67,
                'title' => 'secured_create',
            ],
            [
                'id' => 68,
                'title' => 'secured_edit',
            ],
            [
                'id' => 69,
                'title' => 'secured_show',
            ],
            [
                'id' => 70,
                'title' => 'secured_access',
            ],
            [
                'id' => 71,
                'title' => 'content_management_access',
            ],
            [
                'id' => 72,
                'title' => 'content_category_create',
            ],
            [
                'id' => 73,
                'title' => 'content_category_edit',
            ],
            [
                'id' => 74,
                'title' => 'content_category_show',
            ],
            [
                'id' => 75,
                'title' => 'content_category_delete',
            ],
            [
                'id' => 76,
                'title' => 'content_category_access',
            ],
            [
                'id' => 77,
                'title' => 'content_tag_create',
            ],
            [
                'id' => 78,
                'title' => 'content_tag_edit',
            ],
            [
                'id' => 79,
                'title' => 'content_tag_show',
            ],
            [
                'id' => 80,
                'title' => 'content_tag_delete',
            ],
            [
                'id' => 81,
                'title' => 'content_tag_access',
            ],
            [
                'id' => 82,
                'title' => 'content_page_create',
            ],
            [
                'id' => 83,
                'title' => 'content_page_edit',
            ],
            [
                'id' => 84,
                'title' => 'content_page_show',
            ],
            [
                'id' => 85,
                'title' => 'content_page_delete',
            ],
            [
                'id' => 86,
                'title' => 'content_page_access',
            ],
            [
                'id' => 87,
                'title' => 'audit_log_show',
            ],
            [
                'id' => 88,
                'title' => 'audit_log_access',
            ],
            [
                'id' => 89,
                'title' => 'task_management_access',
            ],
            [
                'id' => 90,
                'title' => 'task_status_create',
            ],
            [
                'id' => 91,
                'title' => 'task_status_edit',
            ],
            [
                'id' => 92,
                'title' => 'task_status_show',
            ],
            [
                'id' => 93,
                'title' => 'task_status_delete',
            ],
            [
                'id' => 94,
                'title' => 'task_status_access',
            ],
            [
                'id' => 95,
                'title' => 'task_tag_create',
            ],
            [
                'id' => 96,
                'title' => 'task_tag_edit',
            ],
            [
                'id' => 97,
                'title' => 'task_tag_show',
            ],
            [
                'id' => 98,
                'title' => 'task_tag_delete',
            ],
            [
                'id' => 99,
                'title' => 'task_tag_access',
            ],
            [
                'id' => 100,
                'title' => 'task_create',
            ],
            [
                'id' => 101,
                'title' => 'task_edit',
            ],
            [
                'id' => 102,
                'title' => 'task_show',
            ],
            [
                'id' => 103,
                'title' => 'task_delete',
            ],
            [
                'id' => 104,
                'title' => 'task_access',
            ],
            [
                'id' => 105,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id' => 106,
                'title' => 'infographic_create',
            ],
            [
                'id' => 107,
                'title' => 'infographic_edit',
            ],
            [
                'id' => 108,
                'title' => 'infographic_show',
            ],
            [
                'id' => 109,
                'title' => 'infographic_delete',
            ],
            [
                'id' => 110,
                'title' => 'infographic_access',
            ],
            [
                'id' => 111,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
