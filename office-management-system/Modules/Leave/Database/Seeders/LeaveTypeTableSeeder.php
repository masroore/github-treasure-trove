<?php

namespace Modules\Leave\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Leave\Entities\LeaveType;

class LeaveTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        LeaveType::truncate();

        LeaveType::insert([

            [
                'name' => 'Sick Leave',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Annual Leave',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }
}
