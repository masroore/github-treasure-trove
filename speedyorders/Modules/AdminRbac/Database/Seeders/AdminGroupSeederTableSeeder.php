<?php

namespace Modules\AdminRbac\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminRbac\Models\AdminGroup;

class AdminGroupSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminGroup::create([
            'name' => 'Super Admin',
            'status' => 1,
        ]);

        AdminGroup::create([
            'name' => 'Admin',
            'status' => 1,
        ]);
    }
}
