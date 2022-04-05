<?php

namespace Database\Seeders;

use App\Models\Quarter;
use App\Models\TaskType;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskType::create([
            'name' => 'assignment',
        ]);
        TaskType::create([
            'name' => 'quiz',
        ]);
        TaskType::create([
            'name' => 'activity',
        ]);
        TaskType::create([
            'name' => 'exam',
        ]);

        Quarter::create(['name' => 'midterm']);
        Quarter::create(['name' => 'finals']);
    }
}
