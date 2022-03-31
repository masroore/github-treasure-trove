<?php

use Illuminate\Database\Seeder;

class CountryRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $script = getcwd() . '/database/seeds/db/country_state.sql';

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($script));

        $this->command->info('Countries Table Seeded');
    }
}
