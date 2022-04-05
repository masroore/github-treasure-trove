<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('units')->delete();

        DB::table('units')->insert([
            0 => [
                'id' => 1,
                'title' => 'Mass',
                'status' => '1',
                'created_at' => '2019-10-31 15:55:29',
                'updated_at' => '2019-10-31 15:55:29',
            ],
            1 => [
                'id' => 2,
                'title' => 'Color',
                'status' => '1',
                'created_at' => '2019-10-31 15:56:49',
                'updated_at' => '2019-10-31 15:56:49',
            ],
        ]);
    }
}
