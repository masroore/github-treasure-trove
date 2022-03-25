<?php

use Illuminate\Database\Seeder;

class LecCourcesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

       // \DB::table('lec_cources')->delete();

        \DB::table('lec_cources')->insert([
            0 => [
                'id' => 1,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Business Management 1',
                'code' => 'BGEC100',
            ],
            1 => [
                'id' => 2,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Business Law ',
                'code' => 'BGEC101',
            ],
            2 => [
                'id' => 3,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Intro to Computer Skills',
                'code' => 'BGEC102',
            ],
            3 => [
                'id' => 4,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Business Statisties',
                'code' => 'BGEC103',
            ],
            4 => [
                'id' => 5,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Communication Skills',
                'code' => 'BGEC104',
            ],
            5 => [
                'id' => 6,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Business Management 11',
                'code' => 'BGEC105',
            ],
            6 => [
                'id' => 7,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Business Communication 1',
                'code' => 'BGEC106',
            ],
            7 => [
                'id' => 8,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Intro to Organisation Behaviour',
                'code' => 'BGEC107',
            ],
            8 => [
                'id' => 9,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Elements of Economics',
                'code' => 'BGEC108',
            ],
            9 => [
                'id' => 10,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Principles of Marketing',
                'code' => 'BGEC109',
            ],
            10 => [
                'id' => 11,
                'lecturer_id' => '5',
                'lec_name' => 'Ahmed Ahia Ogua',
                'course' => 'Business Communication  11',
                'code' => 'BGEC110',
            ],
            11 => [
                'id' => 12,
                'lecturer_id' => '15',
                'lec_name' => 'Toure Domingo',
                'course' => 'Economy of Ghana',
                'code' => 'BCPC203',
            ],
            12 => [
                'id' => 15,
                'lecturer_id' => '15',
                'lec_name' => 'Toure Domingo',
                'course' => 'Sales Management',
                'code' => 'BCPC207',
            ],
        ]);
    }
}
