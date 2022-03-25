<?php

use Illuminate\Database\Seeder;

class UploadedtimetablesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

       // \DB::table('uploadedtimetables')->delete();

        \DB::table('uploadedtimetables')->insert([
            0 => [
                'id' => 1,
                'level' => 'Level 100',
                'session' => 'Morning Session',
                'type' => 'DEGREE',
                'semester' => 'Second Semester',
                'academicyear' => '2020-2021',
                'url' => 'Timetable/Zqh0Iy0aJmUf9APgB3w6cZGaDj153e3wAV8rMK1V.pdf',
            ],
            1 => [
                'id' => 2,
                'level' => 'Level 100',
                'session' => 'Morning Session',
                'type' => 'DEGREE',
                'semester' => 'Second Semester',
                'academicyear' => '2020-2021',
                'url' => 'Timetable/5CzBJFBwg0snn6TqH0VKB7rWAuqLnUJ0lFI2Q7hP.pdf',
            ],
        ]);
    }
}
