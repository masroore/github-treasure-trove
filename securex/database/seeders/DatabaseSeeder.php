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
        $this->call(DefaultLocaleSeeder::class);
        $this->call(TFAPageSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(StatesSeeder::class);
    }
}
