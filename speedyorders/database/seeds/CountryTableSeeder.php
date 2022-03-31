<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $script = getcwd() . '/database/seeds/db/countries.sql';

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($script));

        $this->command->info('Countries Table Seeded');
    }
}
