<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProductAttributesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('product_attributes')->delete();

        DB::table('product_attributes')->insert([
            0 => [
                'id' => 1,
                'attr_name' => 'Color',
                'cats_id' => '["1","2","3","4","5"]',
                'unit_id' => 2,
                'created_at' => '2020-11-19 17:59:44',
                'updated_at' => '2020-11-19 17:59:44',
            ],
            1 => [
                'id' => 3,
                'attr_name' => 'Storage',
                'cats_id' => '["2","4"]',
                'unit_id' => 3,
                'created_at' => '2020-11-19 18:02:29',
                'updated_at' => '2020-11-19 18:02:29',
            ],
            2 => [
                'id' => 4,
                'attr_name' => 'RAM',
                'cats_id' => '["2","4"]',
                'unit_id' => 3,
                'created_at' => '2020-11-19 18:03:24',
                'updated_at' => '2020-11-19 18:03:24',
            ],
            3 => [
                'id' => 5,
                'attr_name' => 'Size',
                'cats_id' => '["3"]',
                'unit_id' => 4,
                'created_at' => '2020-11-19 18:04:54',
                'updated_at' => '2020-11-19 18:04:54',
            ],
        ]);
    }
}
