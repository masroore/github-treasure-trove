<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CoupansTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('coupans')->delete();

        DB::table('coupans')->insert([
            0 => [
                'id' => 1,
                'code' => 'CART100',
                'distype' => 'fix',
                'amount' => '100',
                'link_by' => 'cart',
                'pro_id' => null,
                'cat_id' => null,
                'is_login' => 0,
                'maxusage' => 10,
                'minamount' => 0.0,
                'expirydate' => '2021-08-31 00:00:00',
                'created_at' => '2020-11-19 17:25:59',
                'updated_at' => '2020-11-19 17:25:59',
            ],
            1 => [
                'id' => 2,
                'code' => 'FIRST10',
                'distype' => 'per',
                'amount' => '10',
                'link_by' => 'cart',
                'pro_id' => null,
                'cat_id' => null,
                'is_login' => 1,
                'maxusage' => 10,
                'minamount' => 0.0,
                'expirydate' => '2021-05-31 00:00:00',
                'created_at' => '2020-11-19 17:26:28',
                'updated_at' => '2020-11-19 17:26:28',
            ],
            2 => [
                'id' => 3,
                'code' => 'FLAT60',
                'distype' => 'per',
                'amount' => '60',
                'link_by' => 'cart',
                'pro_id' => null,
                'cat_id' => null,
                'is_login' => 1,
                'maxusage' => 100,
                'minamount' => 1000.0,
                'expirydate' => '2021-06-30 00:00:00',
                'created_at' => '2020-11-19 17:26:54',
                'updated_at' => '2020-11-19 17:26:54',
            ],
        ]);
    }
}
