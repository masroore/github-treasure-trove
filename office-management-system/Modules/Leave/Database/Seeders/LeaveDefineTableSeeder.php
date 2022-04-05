<?php

namespace Modules\Leave\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Leave\Entities\LeaveDefine;

class LeaveDefineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        LeaveDefine::truncate();

        $data = [
            'role_id' => 3,
            'leave_type_id' => 1,
            'total_days' => 15,
            'max_forward' => 10,
            'balance_forward' => 1,
        ];

        LeaveDefine::insert($data);
    }
}
