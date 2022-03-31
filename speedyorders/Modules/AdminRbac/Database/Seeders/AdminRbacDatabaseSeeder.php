<?php

namespace Modules\AdminRbac\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AdminRbacDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdminModuleSeederTableSeeder::class);
        $this->call(AdminGroupSeederTableSeeder::class);
        $this->call(AdminUserSeederTableSeeder::class);
    }
}
