<?php

namespace Database\Seeders;

use App\Models\OrdenPurchases;
use Illuminate\Database\Seeder;

class OrdenPurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        OrdenPurchases::factory()->count(20)->create();
    }
}
