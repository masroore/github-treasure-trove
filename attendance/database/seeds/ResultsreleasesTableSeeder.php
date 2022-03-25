<?php

use Illuminate\Database\Seeder;

class ResultsreleasesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

     //   \DB::table('resultsreleases')->delete();

        \DB::table('resultsreleases')->insert([
            0 => [
                'id' => 1,
                'status' => '1',
            ],
        ]);
    }
}
