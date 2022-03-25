<?php

use Illuminate\Database\Seeder;

class StudentfeesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

      //  \DB::table('studentfees')->delete();

        \DB::table('studentfees')->insert([
            0 => [
                'id' => 1,
                'indexnumber' => 'GES11112',
                'fee' => 'Hostel Refundable Deposit For Damages ',
                'feecode' => ' OFEE104 ',
                'feeamount' => ' 100',
                'paid' => '100',
                'owed' => '0',
                'semester' => '2020-2021',
                'type' => 'mandatory',
            ],
            1 => [
                'id' => 2,
                'indexnumber' => 'GES11112',
                'fee' => 'Undergraduate Degree Morning Fee',
                'feecode' => ' FEE103',
                'feeamount' => '2000',
                'paid' => '2000',
                'owed' => '0',
                'semester' => '2020-2021',
                'type' => 'mandatory',
            ],
            2 => [
                'id' => 3,
                'indexnumber' => 'GES11112',
                'fee' => 'Late Registration Penalty',
                'feecode' => 'OFEE100',
                'feeamount' => '50',
                'paid' => '50',
                'owed' => '0',
                'semester' => '2020-2021',
                'type' => 'request',
            ],
            3 => [
                'id' => 4,
                'indexnumber' => 'GES11112',
                'fee' => 'Destroy Schools Property - fine',
                'feecode' => 'FINE100',
                'feeamount' => '100',
                'paid' => '0',
                'owed' => '100',
                'semester' => '2020-2021',
                'type' => 'mandatory',
            ],
        ]);
    }
}
