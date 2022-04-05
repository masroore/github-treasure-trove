<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Project\Entities\Field;

class FieldTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::create([
            'name' => 'Assignee',
            'type' => 'user_id',
            'default' => 1,
        ]);
        Field::create([
            'name' => 'Due Date',
            'type' => 'date',
            'default' => 1,
        ]);
        Field::create([
            'name' => 'Tags',
            'type' => 'tags',
            'default' => 1,
        ]);
    }
}
