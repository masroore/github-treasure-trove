<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AppSectionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('app_sections')->delete();

        DB::table('app_sections')->insert([
            0 => [
                'id' => 1,
                'name' => 'appheaders',
                'sort' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'categories',
                'sort' => 2,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'specialoffers',
                'sort' => 3,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'flashdeals',
                'sort' => 4,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'sliders',
                'sort' => 5,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'TwoEqualAdvertise',
                'sort' => 6,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'hotdeals',
                'sort' => 7,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 8,
                'name' => 'featuredProducts',
                'sort' => 8,
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'id' => 9,
                'name' => 'ThreeEqualAdvertise',
                'sort' => 9,
                'created_at' => null,
                'updated_at' => null,
            ],
            9 => [
                'id' => 10,
                'name' => 'topCatgories',
                'sort' => 10,
                'created_at' => null,
                'updated_at' => null,
            ],
            10 => [
                'id' => 11,
                'name' => 'SingleAdvertise',
                'sort' => 11,
                'created_at' => null,
                'updated_at' => null,
            ],
            11 => [
                'id' => 12,
                'name' => 'brands',
                'sort' => 12,
                'created_at' => null,
                'updated_at' => null,
            ],
            12 => [
                'id' => 13,
                'name' => 'TwoNonEqualAdvertise',
                'sort' => 13,
                'created_at' => null,
                'updated_at' => null,
            ],
            13 => [
                'id' => 14,
                'name' => 'blogs',
                'sort' => 14,
                'created_at' => null,
                'updated_at' => null,
            ],
            14 => [
                'id' => 15,
                'name' => 'newProducts',
                'sort' => 15,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
