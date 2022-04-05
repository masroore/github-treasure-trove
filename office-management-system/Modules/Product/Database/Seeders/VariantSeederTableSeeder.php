<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Product\Entities\Variant;
use Modules\Product\Entities\VariantValues;

class VariantSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        Variant::insert([

            [
                'id' => 21,
                'name' => 'Size',
                'description' => 'size of any prooduct',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 11:35:23',
                'updated_at' => '2020-10-14 11:35:23',
            ],

            [
                'id' => 22,
                'name' => 'Color',
                'description' => 'Color',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 11:37:01',
                'updated_at' => '2020-10-14 11:37:01',
            ],

            [
                'id' => 23,
                'name' => 'Ram',
                'description' => 'Ram',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 11:43:18',
                'updated_at' => '2020-10-14 11:43:18',
            ],

            [
                'id' => 24,
                'name' => 'SSD',
                'description' => 'SSD',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2020-10-14 11:44:34',
                'updated_at' => '2020-10-14 11:44:34',
            ],

        ]);

        VariantValues::insert([

            [
                'id' => 1,
                'value' => 'L',
                'created_at' => '2020-10-14 11:35:23',
                'updated_at' => '2020-10-14 11:35:23',
            ],

            [
                'id' => 2,
                'value' => 'XL',
                'created_at' => '2020-10-14 11:35:23',
                'updated_at' => '2020-10-14 11:35:23',
            ],

            [
                'id' => 3,
                'value' => 'S',
                'created_at' => '2020-10-14 11:35:23',
                'updated_at' => '2020-10-14 11:35:23',
            ],

            [
                'id' => 4,
                'value' => 'XXL',
                'created_at' => '2020-10-14 11:35:23',
                'updated_at' => '2020-10-14 11:35:23',
            ],

            [
                'id' => 5,
                'value' => 'M',
                'created_at' => '2020-10-14 11:35:23',
                'updated_at' => '2020-10-14 11:35:23',
            ],

            [
                'id' => 6,
                'value' => 'Red',
                'created_at' => '2020-10-14 11:37:01',
                'updated_at' => '2020-10-14 11:37:01',
            ],

            [
                'id' => 7,
                'value' => 'Blue',
                'created_at' => '2020-10-14 11:37:01',
                'updated_at' => '2020-10-14 11:37:01',
            ],

            [
                'id' => 8,
                'value' => 'Black',
                'created_at' => '2020-10-14 11:37:01',
                'updated_at' => '2020-10-14 11:37:01',
            ],

            [
                'id' => 9,
                'value' => 'Green',
                'created_at' => '2020-10-14 11:37:01',
                'updated_at' => '2020-10-14 11:37:01',
            ],

            [
                'id' => 10,
                'value' => 'Megenta',
                'created_at' => '2020-10-14 11:37:01',
                'updated_at' => '2020-10-14 11:37:01',
            ],

            [
                'id' => 11,
                'value' => '2gb',
                'created_at' => '2020-10-14 11:43:18',
                'updated_at' => '2020-10-14 11:43:18',
            ],

            [
                'id' => 12,
                'value' => '4gb',
                'created_at' => '2020-10-14 11:43:18',
                'updated_at' => '2020-10-14 11:43:18',
            ],

            [
                'id' => 13,
                'value' => '8gb',
                'created_at' => '2020-10-14 11:43:18',
                'updated_at' => '2020-10-14 11:43:18',
            ],

            [
                'id' => 14,
                'value' => '16gb',
                'created_at' => '2020-10-14 11:43:18',
                'updated_at' => '2020-10-14 11:43:18',
            ],

            [
                'id' => 15,
                'value' => '128gb',
                'created_at' => '2020-10-14 11:44:34',
                'updated_at' => '2020-10-14 11:44:34',
            ],

            [
                'id' => 16,
                'value' => '500gb',
                'created_at' => '2020-10-14 11:44:34',
                'updated_at' => '2020-10-14 11:44:34',
            ],

            [
                'id' => 17,
                'value' => '1tb',
                'created_at' => '2020-10-14 11:44:34',
                'updated_at' => '2020-10-14 11:44:34',
            ],

        ]);
    }
}
