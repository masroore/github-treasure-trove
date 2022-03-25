<?php

use Illuminate\Database\Seeder;

class Releaseresult extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $releaseresults = new \App\Resultsrelease([
            'status'=> '0',
        ]);

        $releaseresults->save();
    }
}
