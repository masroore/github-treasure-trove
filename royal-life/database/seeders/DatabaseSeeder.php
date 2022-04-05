<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(UserSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoriasSeeder::class);
        $this->call(PackagesTableSeeder::class);
        // $this->call(OrdenPurchaseTableSeeder::class);
        $this->call(RanksTableSeeder::class);
        // $this->call(CountryTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(ServicesTableSeeder::class);
        // $this->call(TimeZoneTableSeeder::class);
        // $this->call(AddSaldoTableSeeder::class);
        // $this->call(WalletTableSeeder::class);
    }
}
