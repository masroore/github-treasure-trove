<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class DummyEnrolStudents extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::get();
        foreach ($courses as $course) {
            $students = User::inRandomOrder()->whereHas('roles', function (Builder $query): void {
                $query->whereRoleId(2);
            })->limit(10)->get();
            $course->students()->attach($students);
        }
    }
}
