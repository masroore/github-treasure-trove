<?php

namespace Database\Seeders;

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
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'examination_access',
            ],
            [
                'id'    => 20,
                'title' => 'faculty_management_access',
            ],
            [
                'id'    => 21,
                'title' => 'department_create',
            ],
            [
                'id'    => 22,
                'title' => 'department_edit',
            ],
            [
                'id'    => 23,
                'title' => 'department_show',
            ],
            [
                'id'    => 24,
                'title' => 'department_delete',
            ],
            [
                'id'    => 25,
                'title' => 'department_access',
            ],
            [
                'id'    => 26,
                'title' => 'faculty_create',
            ],
            [
                'id'    => 27,
                'title' => 'faculty_edit',
            ],
            [
                'id'    => 28,
                'title' => 'faculty_show',
            ],
            [
                'id'    => 29,
                'title' => 'faculty_delete',
            ],
            [
                'id'    => 30,
                'title' => 'faculty_access',
            ],
            [
                'id'    => 31,
                'title' => 'course_create',
            ],
            [
                'id'    => 32,
                'title' => 'course_edit',
            ],
            [
                'id'    => 33,
                'title' => 'course_show',
            ],
            [
                'id'    => 34,
                'title' => 'course_delete',
            ],
            [
                'id'    => 35,
                'title' => 'course_access',
            ],
            [
                'id'    => 36,
                'title' => 'student_management_access',
            ],
            [
                'id'    => 37,
                'title' => 'student_profile_create',
            ],
            [
                'id'    => 38,
                'title' => 'student_profile_edit',
            ],
            [
                'id'    => 39,
                'title' => 'student_profile_show',
            ],
            [
                'id'    => 40,
                'title' => 'student_profile_delete',
            ],
            [
                'id'    => 41,
                'title' => 'student_profile_access',
            ],
            [
                'id'    => 42,
                'title' => 'student_status_check_create',
            ],
            [
                'id'    => 43,
                'title' => 'student_status_check_edit',
            ],
            [
                'id'    => 44,
                'title' => 'student_status_check_show',
            ],
            [
                'id'    => 45,
                'title' => 'student_status_check_delete',
            ],
            [
                'id'    => 46,
                'title' => 'student_status_check_access',
            ],
            [
                'id'    => 47,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
