<?php

use Illuminate\Database\Seeder;

class CdekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->dump();
    }

    protected function dump(): void
    {
        Eloquent::unguard();

        $path = 'database/seeds/cdek.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('CDEK table seeded!');
    }
}
