<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class FrontCatsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('front_cats')->delete();

        DB::table('front_cats')->insert([
            0 => [
                'id' => 1,
                'name' => '1,2,3,4,5',
                'status' => '1',
                'created_at' => '2020-11-19 16:33:11',
                'updated_at' => '2020-11-24 11:39:21',
            ],
        ]);
    }
}
