<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ShippingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('shippings')->delete();

        DB::table('shippings')->insert([
            0 => [
                'id' => 1,
                'name' => 'Free Shipping',
                'price' => null,
                'free' => null,
                'login' => '1',
                'default_status' => '0',
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Local Pickup',
                'price' => 50.0,
                'free' => null,
                'login' => '1',
                'default_status' => '0',
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Flat Rate',
                'price' => 12.0,
                'free' => null,
                'login' => '1',
                'default_status' => '0',
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'UPS Shipping',
                'price' => 5000.0,
                'free' => null,
                'login' => '1',
                'default_status' => '0',
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Shipping Price',
                'price' => null,
                'free' => null,
                'login' => '1',
                'default_status' => '1',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
