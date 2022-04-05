<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

        //\DB::table('menus')->delete();

        \DB::table('menus')->insert([
            0 => [
                'id' => 1,
                'title' => 'Front Desk',
                'order' => 1,
            ],
            1 => [
                'id' => 2,
                'title' => 'Academics Year',
                'order' => 2,
            ],
            2 => [
                'id' => 4,
                'title' => 'Academic Calendar',
                'order' => 3,
            ],
            3 => [
                'id' => 5,
                'title' => 'Pre Admission',
                'order' => 4,
            ],
            4 => [
                'id' => 6,
                'title' => 'Confirm Admission',
                'order' => 5,
            ],
            5 => [
                'id' => 7,
                'title' => 'Admission Doc',
                'order' => 6,
            ],
            6 => [
                'id' => 8,
                'title' => 'Revert Admission',
                'order' => 7,
            ],
            7 => [
                'id' => 9,
                'title' => 'Add Student',
                'order' => 8,
            ],
            8 => [
                'id' => 10,
                'title' => 'Student Portal',
                'order' => 9,
            ],
            9 => [
                'id' => 11,
                'title' => 'Lecturer',
                'order' => 101,
            ],
            10 => [
                'id' => 13,
                'title' => 'All studentds',
                'order' => 102,
            ],
            11 => [
                'id' => 14,
                'title' => 'Level 100',
                'order' => 11,
            ],
            12 => [
                'id' => 15,
                'title' => 'Level 200',
                'order' => 12,
            ],
            13 => [
                'id' => 16,
                'title' => 'Level 300',
                'order' => 13,
            ],
            14 => [
                'id' => 17,
                'title' => 'Level 400',
                'order' => 14,
            ],
            15 => [
                'id' => 18,
                'title' => 'Graduated Students',
                'order' => 15,
            ],
            16 => [
                'id' => 19,
                'title' => 'Student Punishment',
                'order' => 16,
            ],
            17 => [
                'id' => 20,
                'title' => 'Student Promotion',
                'order' => 17,
            ],
            18 => [
                'id' => 21,
                'title' => 'Disable Student',
                'order' => 18,
            ],
            19 => [
                'id' => 22,
                'title' => 'Add Programme',
                'order' => 19,
            ],
            20 => [
                'id' => 23,
                'title' => 'Add Faculty',
                'order' => 20,
            ],
            21 => [
                'id' => 24,
                'title' => 'Add Course',
                'order' => 21,
            ],
            22 => [
                'id' => 25,
                'title' => 'All Degree',
                'order' => 22,
            ],
            23 => [
                'id' => 26,
                'title' => 'All Diploma',
                'order' => 23,
            ],
            24 => [
                'id' => 27,
                'title' => 'Programmes and Courses',
                'order' => 24,
            ],
            25 => [
                'id' => 28,
                'title' => 'Add Hall',
                'order' => 25,
            ],
            26 => [
                'id' => 29,
                'title' => 'Add Timetable',
                'order' => 26,
            ],
            27 => [
                'id' => 30,
                'title' => 'Generate Timetable',
                'order' => 27,
            ],
            28 => [
                'id' => 31,
                'title' => 'Upload Timetable',
                'order' => 28,
            ],
            29 => [
                'id' => 32,
                'title' => 'Student Grouping',
                'order' => 29,
            ],
            30 => [
                'id' => 33,
                'title' => 'Results Management',
                'order' => 30,
            ],
            31 => [
                'id' => 34,
                'title' => 'Polls Management',
                'order' => 31,
            ],
            32 => [
                'id' => 35,
                'title' => 'Online Meetings',
                'order' => 32,
            ],
            33 => [
                'id' => 36,
                'title' => 'Communicate',
                'order' => 33,
            ],
            34 => [
                'id' => 37,
                'title' => 'Accounts',
                'order' => 34,
            ],
            35 => [
                'id' => 38,
                'title' => 'Human Resource',
                'order' => 35,
            ],
            36 => [
                'id' => 39,
                'title' => 'Support Tickets',
                'order' => 36,
            ],
            37 => [
                'id' => 41,
                'title' => 'User Management',
                'order' => 37,
            ],
        ]);
    }
}
