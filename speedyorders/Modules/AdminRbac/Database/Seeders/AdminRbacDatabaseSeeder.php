<?php

namespace Modules\AdminRbac\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AdminRbacDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(AdminModuleSeederTableSeeder::class);
        $this->call(AdminGroupSeederTableSeeder::class);
        $this->call(AdminUserSeederTableSeeder::class);
    }
}
