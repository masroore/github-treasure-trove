<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SubmissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('submissions')->delete();

        DB::table('submissions')->insert([
            0 => [
                'answers' => '[{"answers": "dawdaw", "identifier": 1628113822324832}, {"answers": "Choice A", "identifier": 1628113847503934}, {"answers": "true", "identifier": 1628113847936022}, {"answers": ["dawd", "dad"], "identifier": 1628113848490336}, {"answers": "dawdawdaw\\ndawdaw\\nd\\nawd", "identifier": 1628113848997895}, {"answers": [], "identifier": 1628113853264251}]',
                'created_at' => '2021-08-05 06:54:13',
                'date_submitted' => '2021-08-05 06:54:13',
                'date_graded' => null,
                'id' => 3,
                'task_id' => 1,
                'updated_at' => '2021-08-05 06:54:13',
                'user_id' => 2,
            ],
        ]);
    }
}
