<?php

use Illuminate\Database\Seeder;

class AcademicyearsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

        //\DB::table('academicyears')->delete();

        \DB::table('academicyears')->insert([
            0 => [
                'id' => 1,
                'acdemicyear' => '2020-2021',
                'semester' => 'First Semester',
                'status' => '0',
            ],
            1 => [
                'id' => 2,
                'acdemicyear' => '2020-2021',
                'semester' => 'Second Semester',
                'status' => '1',
            ],
            2 => [
                'id' => 3,
                'acdemicyear' => '2021-2022',
                'semester' => 'First Semester',
                'status' => '0',
            ],
            3 => [
                'id' => 4,
                'acdemicyear' => '2021-2022',
                'semester' => 'Second Semester',
                'status' => '0',
            ],
        ]);
    }
}
