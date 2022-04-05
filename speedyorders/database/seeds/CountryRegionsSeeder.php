<?php

use Illuminate\Database\Seeder;

class CountryRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $script = getcwd() . '/database/seeds/db/country_state.sql';

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($script));

        $this->command->info('Countries Table Seeded');
    }
}
