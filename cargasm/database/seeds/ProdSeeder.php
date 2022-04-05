<?php

use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(MenuSeeder::class);
    }
}
