<?php

use Illuminate\Database\Seeder;

class Programseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Arts in Public Relations Management',
                'type' => 'Degree Programme',
                'code' => 'BAPR',
                'duration' => '4',
                'department' => 'Public Relations',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Diploma in Accounting',
                'type' => 'Diploma Programme',
                'code' => 'DIAC',
                'duration' => '2',
                'department' => 'Accounting and Finance',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Science in Accounting',
                'type' => 'Degree Programme',
                'code' => 'BSAC',
                'duration' => '4',
                'department' => 'Accounting and Finance',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Science in Accounting and Finance',
                'type' => 'Degree Programme',
                'code' => 'BIAF',
                'duration' => '4',
                'department' => 'Accounting and Finance',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Science in Business Economics',
                'type' => 'Degree Programme',
                'code' => 'BSBE',
                'duration' => '4',
                'department' => 'Business Economics',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Science in Actuarial Science',
                'type' => 'Degree Programme',
                'code' => 'BIAS',
                'duration' => '4',
                'department' => 'Actuarial Science',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Science in Banking and Finance',
                'type' => 'Degree Programme',
                'code' => 'BIBF',
                'duration' => '4',
                'department' => 'Banking and Finance',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Bachelor of Business Administration',
                'type' => 'Degree Programme',
                'code' => 'BBAD',
                'duration' => '4',
                'department' => 'Business Administration',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Diploma in Management',
                'type' => 'Diploma Programme',
                'code' => 'DIMM',
                'duration' => '2',
                'department' => 'Public Relations',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Diploma in Public Relations',
                'type' => 'Diploma Programme',
                'code' => 'DIPR',
                'duration' => '2',
                'department' => 'Public Relations',
            ]
        );
        $post->save();

        $post = new \App\Programme(
            [
                'name' => 'Diploma in Information Technology Management',
                'type' => 'Diploma Programme',
                'code' => 'DITM',
                'duration' => '2',
                'department' => 'Information Technology Management',
            ]
        );
        $post->save();
    }
}
