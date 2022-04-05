<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::get();
        foreach ($courses as $c) {
            $rand = mt_rand(1, 7);
            $c->image()->create([
                'url' => "/img/bg/bg($rand).jpg",
            ]);
        }
        // Course::factory()->count(100)->create()->each(function ($c) {
        //     $rand = rand(1, 7);
        //     $c->image()->create([
        //         'url' => "/img/bg/bg($rand).jpg"
        //     ]);
        // });
    }
}
