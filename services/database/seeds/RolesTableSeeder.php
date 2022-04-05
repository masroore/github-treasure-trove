<?php
/*
 * File name: RolesTableSeeder.php
 * Last modified: 2021.03.01 at 21:37:06
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            0 => [
                'id' => 2,
                'name' => 'admin',
                'guard_name' => 'web',
                'default' => 0,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 3,
                'name' => 'provider',
                'guard_name' => 'web',
                'default' => 0,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 4,
                'name' => 'customer',
                'guard_name' => 'web',
                'default' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
