<?php

namespace Modules\Leave\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class LeaveDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(LeaveTypeTableSeeder::class);
        $this->call(LeaveDefineTableSeeder::class);
        $this->call(ApplyLeaveTableSeeder::class);
    }
}
