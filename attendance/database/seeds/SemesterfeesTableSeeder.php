<?php

use Illuminate\Database\Seeder;

class SemesterfeesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

       // \DB::table('semesterfees')->delete();

        \DB::table('semesterfees')->insert([
            0 => [
                'id' => 2,
                'level' => 'Level 100',
                'session' => 'Weekend Session',
                'fee' => 'Undergraduate Degree Weekend Fee',
                'feecode' => ' FEE102',
                'feeamount' => '2500',
                'academicyear' => '2020-2021',
            ],
            1 => [
                'id' => 3,
                'level' => 'Level 100',
                'session' => 'Morning Session',
                'fee' => 'Hostel Refundable Deposit For Damages ',
                'feecode' => ' OFEE104 ',
                'feeamount' => ' 100',
                'academicyear' => '2020-2021',
            ],
            2 => [
                'id' => 4,
                'level' => 'Level 100',
                'session' => 'Evening Session',
                'fee' => 'Hostel Refundable Deposit For Damages ',
                'feecode' => ' OFEE104 ',
                'feeamount' => ' 100',
                'academicyear' => '2020-2021',
            ],
            3 => [
                'id' => 5,
                'level' => 'Level 100',
                'session' => 'Weekend Session',
                'fee' => 'Hostel Refundable Deposit For Damages ',
                'feecode' => ' OFEE104 ',
                'feeamount' => ' 100',
                'academicyear' => '2020-2021',
            ],
            4 => [
                'id' => 6,
                'level' => 'Level 100',
                'session' => 'Morning Session',
                'fee' => 'Undergraduate Degree Morning Fee',
                'feecode' => ' FEE103',
                'feeamount' => '2000',
                'academicyear' => '2020-2021',
            ],
            5 => [
                'id' => 7,
                'level' => 'Level 100',
                'session' => 'Evening Session',
                'fee' => 'Undergraduate Degree Evening Fee',
                'feecode' => ' FEE101',
                'feeamount' => '2000',
                'academicyear' => '2020-2021',
            ],
        ]);
    }
}
