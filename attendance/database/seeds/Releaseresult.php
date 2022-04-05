<?php

use Illuminate\Database\Seeder;

class Releaseresult extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $releaseresults = new \App\Resultsrelease([
            'status' => '0',
        ]);

        $releaseresults->save();
    }
}
