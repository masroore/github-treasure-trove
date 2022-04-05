<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

        //\DB::table('roles')->delete();

        \DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'name' => 'is_admin',
                'guard_name' => 'web',
            ],
            1 => [
                'id' => 2,
                'name' => 'is_superAdmin',
                'guard_name' => 'web',
            ],
            2 => [
                'id' => 3,
                'name' => 'Student',
                'guard_name' => 'web',
            ],
            3 => [
                'id' => 4,
                'name' => 'Lecturer',
                'guard_name' => 'web',
            ],
            4 => [
                'id' => 5,
                'name' => 'Admission committee',
                'guard_name' => 'web',
            ],
            5 => [
                'id' => 6,
                'name' => 'Front_desk_help',
                'guard_name' => 'web',
            ],
            6 => [
                'id' => 7,
                'name' => 'Academic Committee',
                'guard_name' => 'web',
            ],
            7 => [
                'id' => 8,
                'name' => 'Nabco Trainee',
                'guard_name' => 'web',
            ],
            8 => [
                'id' => 9,
                'name' => 'National Service',
                'guard_name' => 'web',
            ],
            9 => [
                'id' => 10,
                'name' => 'Accounts',
                'guard_name' => 'web',
            ],
            10 => [
                'id' => 11,
                'name' => 'Head Of Academics',
                'guard_name' => 'web',
            ],
            11 => [
                'id' => 14,
                'name' => 'Developer',
                'guard_name' => 'web',
            ],
            12 => [
                'id' => 15,
                'name' => 'Human Resource Manager',
                'guard_name' => 'web',
            ],
        ]);
    }
}
