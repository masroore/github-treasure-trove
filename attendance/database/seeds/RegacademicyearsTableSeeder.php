<?php

use Illuminate\Database\Seeder;

class RegacademicyearsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

       // \DB::table('regacademicyears')->delete();

        \DB::table('regacademicyears')->insert([
            0 => [
                'id' => 1,
                'user_id' => '3',
                'academicyear' => '2020-2021',
                'semester' => 'First Semester',
            ],
            1 => [
                'id' => 2,
                'user_id' => '3',
                'academicyear' => '2020-2021',
                'semester' => 'Second Semester',
            ],
        ]);
    }
}
