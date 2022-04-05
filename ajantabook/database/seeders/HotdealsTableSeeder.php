<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class HotdealsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('hotdeals')->delete();

        DB::table('hotdeals')->insert([
            0 => [
                'id' => 1,
                'pro_id' => 8,
                'status' => '1',
                'created_at' => '2020-11-24 14:45:09',
                'updated_at' => '2020-11-24 14:45:19',
                'start' => '2020-11-25',
                'end' => '2021-07-24',
            ],
            1 => [
                'id' => 2,
                'pro_id' => 7,
                'status' => '1',
                'created_at' => '2020-11-24 14:45:32',
                'updated_at' => '2020-11-24 14:45:32',
                'start' => '2020-11-25',
                'end' => '2021-01-01',
            ],
            2 => [
                'id' => 3,
                'pro_id' => 9,
                'status' => '1',
                'created_at' => '2020-11-24 14:45:47',
                'updated_at' => '2020-11-24 14:45:47',
                'start' => '2020-11-11',
                'end' => '2020-12-31',
            ],
        ]);
    }
}
