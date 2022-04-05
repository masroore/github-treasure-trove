<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\ModelType;

class ModelSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        ModelType::insert([

            [
                'id' => 1,
                'name' => 'A51',
                'description' => 'A51',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:22:12',
                'updated_at' => '2020-10-14 12:22:12',
            ],

            [
                'id' => 2,
                'name' => 'M01',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:22:27',
                'updated_at' => '2020-10-14 12:22:27',
            ],

            [
                'id' => 3,
                'name' => 'M11',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:23:12',
                'updated_at' => '2020-10-14 12:23:12',
            ],

            [
                'id' => 4,
                'name' => 'A01',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:23:25',
                'updated_at' => '2020-10-14 12:23:25',
            ],

            [
                'id' => 5,
                'name' => 'A71',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:23:39',
                'updated_at' => '2020-10-14 12:23:39',
            ],

            [
                'id' => 6,
                'name' => 'A20',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:24:04',
                'updated_at' => '2020-10-14 12:24:04',
            ],

            [
                'id' => 7,
                'name' => 'Y20',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:24:26',
                'updated_at' => '2020-10-14 12:24:26',
            ],

            [
                'id' => 8,
                'name' => 'Note 10',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:24:55',
                'updated_at' => '2020-10-14 12:24:55',
            ],

            [
                'id' => 9,
                'name' => 'Note 10 pro',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:25:12',
                'updated_at' => '2020-10-14 12:25:12',
            ],

            [
                'id' => 10,
                'name' => 'Note 10 lite',
                'description' => '',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 12:26:05',
                'updated_at' => '2020-10-14 12:26:05',
            ],

        ]);
    }
}
