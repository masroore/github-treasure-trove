<?php

use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('email_templates')->truncate();

        $script = getcwd() . '/database/seeds/db/email_templates.sql';

        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($script));

        $this->command->info('Email templates Table Seeded');
    }
}
