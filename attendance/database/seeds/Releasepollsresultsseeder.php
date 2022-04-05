<?php

use Illuminate\Database\Seeder;

class Releasepollsresultsseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $releaseresults = new \App\Pollsrelease([
            'status' => '0',
        ]);

        $releaseresults->save();
    }
}
