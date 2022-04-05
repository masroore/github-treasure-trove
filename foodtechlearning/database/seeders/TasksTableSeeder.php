<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('tasks')->delete();

        DB::table('tasks')->insert([
            0 => [
                'course_id' => 1,
                'task_type_id' => 2,
                'created_at' => '2021-08-05 05:54:01',
                'deadline' => '2021-08-13 12:00:00',
                'deleted_at' => null,
                'id' => 1,
                'instructions' => 'This are the task instructions',
                'name' => 'This is a sample Task',
                'questions' => '[{"body": "This is the identification question", "type": "identification", "links": [], "points": 1, "answers": ["The Answer"], "choices": [], "identifier": 1628113822324832, "file_required": false}, {"body": "This is the multiple choice question.", "type": "multiple choice", "links": [], "points": 1, "answers": ["Choice B"], "choices": ["Choice A", "Choice B", "Choice C"], "identifier": 1628113847503934, "file_required": false}, {"body": "This is the true or false question.", "type": "true or false", "links": [], "points": "1", "answers": ["true"], "choices": ["true", "false"], "identifier": 1628113847936022, "file_required": false}, {"body": "This is the enumeration question.", "type": "enumeration", "links": [], "points": "2", "answers": ["Answer A", "Answer B"], "choices": [], "identifier": 1628113848490336, "file_required": false}, {"body": "This is the essay question.", "type": "essay", "links": [], "points": "10", "answers": [], "choices": [], "identifier": 1628113848997895, "file_required": false}, {"body": "This is the problem solving question. Upload a file for your answer.", "type": "problem solving", "links": [], "points": "20", "answers": [], "choices": [], "identifier": 1628113853264251, "file_required": true}]',
                'updated_at' => '2021-08-05 05:54:01',
            ],
        ]);
    }
}
