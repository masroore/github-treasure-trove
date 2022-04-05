<?php

use Illuminate\Database\Seeder;

class TimetablegroupsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {

    //   \DB::table('timetablegroups')->delete();

        \DB::table('timetablegroups')->insert([
            0 => [
                'id' => 1,
                'timetable_id' => '1',
                'group' => '',
                'hall' => 'LBC 100',
                'lecturer' => 'Ahmed Ahia Ogua',
                'lecturer_id' => '5',
                'capacity' => '200',
            ],
        ]);
    }
}
