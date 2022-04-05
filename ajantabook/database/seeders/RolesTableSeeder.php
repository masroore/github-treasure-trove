<?php

namespace Database\Seeders;

use DB;
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
                'id' => 1,
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 09:12:31',
                'updated_at' => '2021-05-27 09:17:32',
            ],
            1 => [
                'id' => 2,
                'name' => 'Customer',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 09:13:58',
                'updated_at' => '2021-05-27 09:13:58',
            ],
            2 => [
                'id' => 3,
                'name' => 'Seller',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 09:14:04',
                'updated_at' => '2021-05-27 09:14:04',
            ],
            3 => [
                'id' => 4,
                'name' => 'Blocked',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 09:14:10',
                'updated_at' => '2021-05-27 09:14:10',
            ],
            4 => [
                'id' => 5,
                'name' => 'Support',
                'guard_name' => 'web',
                'created_at' => '2021-05-27 09:18:41',
                'updated_at' => '2021-05-27 09:18:41',
            ],
        ]);
    }
}
