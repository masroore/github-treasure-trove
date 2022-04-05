<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class BankDetailsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('bank_details')->delete();

        DB::table('bank_details')->insert([
            0 => [
                'id' => 1,
                'bankname' => 'State Bank Of India',
                'branchname' => 'BHL EVE',
                'ifsc' => 'SBIN000123',
                'account' => '1234568954',
                'acountname' => 'Admin',
                'status' => '1',
                'created_at' => '2019-02-06 15:45:18',
                'updated_at' => '2019-07-23 10:03:18',
            ],
        ]);
    }
}
