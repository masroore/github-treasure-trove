<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

      //  \DB::table('staff')->delete();

        \DB::table('staff')->insert([
            0 => [
                'id' => 1,
                'user_id' => '5',
                'role' => 'Lecturer',
                'fullname' => 'Ahmed Ahia Ogua',
                'dateofbirth' => '2021-11-22',
                'address' => 'P. o. box ts 367',
                'faculty' => 'Others',
                'gender' => 'Male',
                'religion' => 'Moslem',
                'qualification' => 'Bsc in information mngmrnt',
                'number' => '0272185091',
                'fathername' => 'ogua',
                'mothername' => 'Ahmed Mason',
                'maritalstatus' => 'Married',
                'workexperience' => 'Bsc in information mngmrnt',
                'eployid' => 'LEC1019330',
                'salarygrade' => 'Grade 2',
                'salary' => '2000',
                'acctitle' => null,
                'accnum' => null,
                'bankname' => null,
                'bankbranch' => null,
                'resumedoc' => 'Resume/jmXifWkqXJlWlKVhgd2NLj78yUBSLtqPTKvGjorC.pdf',
            ],
            1 => [
                'id' => 2,
                'user_id' => '15',
                'role' => 'Front_desk_help',
                'fullname' => 'Toure Domingo',
                'dateofbirth' => '2021-11-25',
                'address' => 'P. o. box ts 367',
                'faculty' => 'Help Desk',
                'gender' => 'Male',
                'religion' => 'Moslem',
                'qualification' => 'bsc science',
                'number' => '0272185090',
                'fathername' => 'Junior Lamere',
                'mothername' => 'Ahmed Mason',
                'maritalstatus' => 'Married',
                'workexperience' => 'bsc science',
                'eployid' => 'OSMS1037870',
                'salarygrade' => 'Grade 1',
                'salary' => '1000',
                'acctitle' => null,
                'accnum' => null,
                'bankname' => null,
                'bankbranch' => null,
                'resumedoc' => null,
            ],
        ]);
    }
}
