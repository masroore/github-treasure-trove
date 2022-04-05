<?php

use Illuminate\Database\Seeder;

class HallsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

       // \DB::table('halls')->delete();

        \DB::table('halls')->insert([
            0 => [
                'id' => 1,
                'name' => 'LBC 100',
                'capacity' => '200',
            ],
            1 => [
                'id' => 2,
                'name' => 'LBC 101',
                'capacity' => '150',
            ],
        ]);
    }
}
