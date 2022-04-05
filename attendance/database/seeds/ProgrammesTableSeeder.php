<?php

use Illuminate\Database\Seeder;

class ProgrammesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

       // \DB::table('programmes')->delete();

        \DB::table('programmes')->insert([
            0 => [
                'id' => 1,
                'name' => 'Bachelor of Science in Information Technology Management',
                'code' => 'BITM',
                'type' => 'Degree Programme',
                'duration' => '4',
                'department' => 'Department of Information Technology Management',
            ],
            1 => [
                'id' => 2,
                'name' => 'Bachelor of Arts in Public Relations Management',
                'code' => 'BAPR',
                'type' => 'Degree Programme',
                'duration' => '4',
                'department' => 'Department of public relations',
            ],
            2 => [
                'id' => 3,
                'name' => 'Diploma in Accounting',
                'code' => 'DIAA',
                'type' => 'Diploma Programme',
                'duration' => '3',
                'department' => 'Department of Accounting',
            ],
        ]);
    }
}
