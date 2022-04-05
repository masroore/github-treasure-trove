<?php

namespace Database\Seeders;

use App\Coupon;

use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'ABC123',
            'type' => 'fixed',
            'value' => 20,
        ]);

        Coupon::create([
            'code' => 'DEF123',
            'type' => 'percent',
            'percent_off' => 50,
        ]);
    }
}
