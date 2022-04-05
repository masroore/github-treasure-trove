<?php

use Illuminate\Database\Seeder;

class MandatoryFeesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

       // \DB::table('mandatory_fees')->delete();

        \DB::table('mandatory_fees')->insert([
            0 => [
                'id' => 2,
                'title' => 'Undergraduate Degree Evening Fee',
                'feecode' => 'FEE101',
            ],
            1 => [
                'id' => 3,
                'title' => 'Undergraduate Degree Weekend Fee',
                'feecode' => 'FEE102',
            ],
            2 => [
                'id' => 4,
                'title' => 'Undergraduate Degree Morning Fee',
                'feecode' => 'FEE103',
            ],
            3 => [
                'id' => 6,
                'title' => 'Students Representative Council Dues',
                'feecode' => 'FEE104',
            ],
            4 => [
                'id' => 7,
                'title' => 'Sports Levy',
                'feecode' => 'FEE105',
            ],
            5 => [
                'id' => 8,
                'title' => 'Hostel Fund',
                'feecode' => 'FEE106',
            ],
            6 => [
                'id' => 9,
                'title' => 'Medical Levy 2',
                'feecode' => 'FEE107',
            ],
            7 => [
                'id' => 10,
                'title' => 'Utility Bill Fee',
                'feecode' => 'FEE108',
            ],
            8 => [
                'id' => 11,
                'title' => 'FACULTY DUES',
                'feecode' => 'FEE109',
            ],
            9 => [
                'id' => 12,
                'title' => 'Alumni Registration fee',
                'feecode' => 'FEE110',
            ],
            10 => [
                'id' => 16,
                'title' => 'Undergraduate Dipolma Morning Fees',
                'feecode' => 'FEE111',
            ],
            11 => [
                'id' => 17,
                'title' => 'Undergraduate Diploma Evening Fee',
                'feecode' => 'FEE112',
            ],
            12 => [
                'id' => 18,
                'title' => 'Undergraduate Diploma Weekend Fee',
                'feecode' => 'FEE113',
            ],
        ]);
    }
}
