<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MultiCurrenciesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('multi_currencies')->delete();

        DB::table('multi_currencies')->insert([
            0 => [
                'id' => 1,
                'position' => 'l',
                'row_id' => 1,
                'default_currency' => 1,
                'currency_id' => '53',
                'add_amount' => null,
                'currency_symbol' => 'fa fa-inr',
                'rate' => 1.0,
                'created_at' => null,
                'updated_at' => '2019-10-21 11:06:30',
            ],
        ]);
    }
}
