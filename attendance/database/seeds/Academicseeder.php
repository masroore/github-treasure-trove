<?php

use Illuminate\Database\Seeder;

class Academicseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academic = new \App\Academicyear([
            'acdemicyear' => '2020-2021',
            'semester' => 'First Semester',
            'status' => '1',
        ]);

        $academic->save();

        $academic2 = new \App\Academicyear([
            'acdemicyear' => '2020-2021',
            'semester' => 'Second Semester',
            'status' => '0',
        ]);

        $academic2->save();

        $academic3 = new \App\Academicyear([
            'acdemicyear' => '2021-2022',
            'semester' => 'First Semester',
            'status' => '0',
        ]);

        $academic3->save();

        $academic4 = new \App\Academicyear([
            'acdemicyear' => '2021-2022',
            'semester' => 'Second Semester',
            'status' => '0',
        ]);

        $academic4->save();
    }
}
