<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\Section;
use Modules\Project\Entities\Task;

class ProjectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::create([
            'user_id' => 1,
            'team_id' => 1,
            'name' => 'Test Project',
            'privacy' => 1,
            'default_view' => 'list',
            'uuid' => uniqid('infix_'),
        ]);

        $project->users()->attach($project->user_id, ['icon' => 'ti-menu-alt', 'color' => '6457f9', 'default_view' => $project->default_view]);

        $project->fields()->attach(1, ['order' => 0]);
        $project->fields()->attach(2, ['order' => 2]);
        $project->fields()->attach(3, ['order' => 1]);

        Section::create([
            'project_id' => $project->id,
            'name' => 'Untitled Section',
            'order' => 0,
        ]);

        Section::create([
            'project_id' => $project->id,
            'name' => 'Section 01',
            'order' => 2,
        ]);

        Section::create([
            'project_id' => $project->id,
            'name' => 'Section 02',
            'order' => 1,
        ]);

        $task = Task::create([
            'project_id' => $project->id,
            'section_id' => 2,
            'uuid' => uniqid('task-'),
            'name' => 'Task 01',
            'created_by' => 1,
            'order' => 1,
        ]);

        $task->fields()->attach(1);
        $task->fields()->attach(2, ['date' => '2021-01-28']);
        $task->fields()->attach(3);

        $task = Task::create([
            'project_id' => $project->id,
            'uuid' => uniqid('task-'),
            'section_id' => 2,
            'name' => 'Task 03',
            'created_by' => 1,
            'order' => 2,
        ]);

        $task->fields()->attach(1);
        $task->fields()->attach(2, ['date' => '2021-01-27']);
        $task->fields()->attach(3);

        $task = Task::create([
            'project_id' => $project->id,
            'uuid' => uniqid('task-'),
            'section_id' => 3,
            'name' => 'Task 02',
            'created_by' => 1,
            'order' => 1,
        ]);

        $task->fields()->attach(1);
        $task->fields()->attach(2, ['date' => '2021-01-26']);
        $task->fields()->attach(3);

        $task = Task::create([
            'project_id' => $project->id,
            'uuid' => uniqid('task-'),
            'section_id' => 3,
            'name' => 'Task 01',
            'created_by' => 1,
            'order' => 2,
        ]);

        $task->fields()->attach(1);
        $task->fields()->attach(2, ['date' => '2021-01-24']);
        $task->fields()->attach(3);

        $task = Task::create([
            'project_id' => $project->id,
            'uuid' => uniqid('task-'),
            'section_id' => 1,
            'name' => 'Task 01',
            'created_by' => 1,
            'order' => 2,
        ]);

        $task->fields()->attach(1);
        $task->fields()->attach(2, ['date' => '2021-01-29']);
        $task->fields()->attach(3);

        $task = Task::create([
            'project_id' => $project->id,
            'parent_id' => 1,
            'uuid' => uniqid('task-'),
            'name' => 'Sub Task 01',
            'created_by' => 1,
            'order' => 0,
        ]);

        $task->fields()->attach(1);
        $task->fields()->attach(2, ['date' => '2021-01-29']);
        $task->fields()->attach(3);
    }
}
