<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CategorySlidersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('category_sliders')->delete();

        DB::table('category_sliders')->insert([
            0 => [
                'id' => 1,
                'category_ids' => '["2"]',
                'pro_limit' => 10,
                'status' => 1,
            ],
        ]);
    }
}
