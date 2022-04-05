<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\UnitType;

class UnitTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        UnitType::insert([

            [
                'id' => 51,
                'name' => 'Piece',
                'description' => 'per Piece',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:04:38',
                'updated_at' => '2020-10-14 12:04:38',
            ],

            [
                'id' => 52,
                'name' => 'Kg',
                'description' => 'kilo gram',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:05:12',
                'updated_at' => '2020-10-14 12:05:12',
            ],

            [
                'id' => 53,
                'name' => 'lot',
                'description' => 'lot',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:05:34',
                'updated_at' => '2020-10-14 12:05:34',
            ],

            [
                'id' => 54,
                'name' => 'Ton',
                'description' => 'ton',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:05:56',
                'updated_at' => '2020-10-14 12:05:56',
            ],

            [
                'id' => 55,
                'name' => 'Liter',
                'description' => 'liter',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:08:19',
                'updated_at' => '2020-10-14 12:08:19',
            ],

        ]);
    }
}
