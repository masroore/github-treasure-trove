<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AdvsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('advs')->delete();

        DB::table('advs')->insert([
            0 => [
                'id' => 1,
                'layout' => 'Single image layout',
                'position' => 'abovefeaturedproduct',
                'status' => 1,
                'image1' => '1606209610cat-banner-1.jpg',
                'image2' => null,
                'image3' => null,
                'url1' => null,
                'url2' => null,
                'url3' => null,
                'pro_id1' => null,
                'pro_id2' => null,
                'pro_id3' => null,
                'cat_id1' => 2,
                'cat_id2' => null,
                'cat_id3' => null,
                'created_at' => '2020-11-24 14:50:10',
                'updated_at' => '2020-11-24 14:50:10',
            ],
            1 => [
                'id' => 2,
                'layout' => 'Three Image Layout',
                'position' => 'abovenewproduct',
                'status' => 1,
                'image1' => '1606209691home-banner1.jpg',
                'image2' => '1606209691home-banner2.jpg',
                'image3' => '1606209691home-banner3.jpg',
                'url1' => null,
                'url2' => null,
                'url3' => null,
                'pro_id1' => null,
                'pro_id2' => null,
                'pro_id3' => null,
                'cat_id1' => 3,
                'cat_id2' => 4,
                'cat_id3' => 3,
                'created_at' => '2020-11-24 14:51:31',
                'updated_at' => '2020-11-24 14:51:31',
            ],
        ]);
    }
}
