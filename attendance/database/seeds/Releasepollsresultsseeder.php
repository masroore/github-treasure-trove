<?php

use Illuminate\Database\Seeder;

class Releasepollsresultsseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $releaseresults = new \App\Pollsrelease([
            'status'=> '0',
        ]);

        $releaseresults->save();
    }
}
