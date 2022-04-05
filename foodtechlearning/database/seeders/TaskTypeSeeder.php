<?php

namespace Database\Seeders;

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
            'name' => 'laboratory activity',
        ]);
        TaskType::create([
            'name' => 'exam',
        ]);
    }
}
