<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('sliders')->delete();

        DB::table('sliders')->insert([
            0 => [
                'id' => 1,
                'link_by' => 'none',
                'category_id' => null,
                'child' => null,
                'grand_id' => null,
                'topheading' => '{"en":"Fashion Deals"}',
                'heading' => '{"en":"60% off"}',
                'buttonname' => '{"en":"SHOP NOW"}',
                'btntextcolor' => '#ffffff',
                'btnbgcolor' => '#000000',
                'moredesc' => null,
                'moredesccolor' => '#000000',
                'image' => '160578619102.jpg',
                'url' => null,
                'headingtextcolor' => '#000000',
                'subheadingcolor' => '#000000',
                'product_id' => null,
                'status' => '1',
                'created_at' => '2020-11-19 17:13:11',
                'updated_at' => '2020-11-19 17:13:42',
            ],
            1 => [
                'id' => 2,
                'link_by' => 'none',
                'category_id' => null,
                'child' => null,
                'grand_id' => null,
                'topheading' => '{"en":"Music Never Stops"}',
                'heading' => '{"en":"Arrival of smart era"}',
                'buttonname' => '{"en":"BUY NOW"}',
                'btntextcolor' => '#ffffff',
                'btnbgcolor' => '#de3b3b',
                'moredesc' => null,
                'moredesccolor' => '#000000',
                'image' => '160578632001.jpg',
                'url' => null,
                'headingtextcolor' => '#ffffff',
                'subheadingcolor' => '#ffffff',
                'product_id' => null,
                'status' => '1',
                'created_at' => '2020-11-19 17:15:21',
                'updated_at' => '2020-11-19 17:15:37',
            ],
        ]);
    }
}
