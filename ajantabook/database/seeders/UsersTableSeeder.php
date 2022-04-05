<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            0 => [
                'id' => 1,
                'role_id' => 'a',
                'name' => 'Admin',
                'email' => 'admin@mediacity.co.in',
                'email_verified_at' => null,
                'password' => bcrypt(123456),
                'mobile' => '1234567890',
                'phone' => '1234567890',
                'city_id' => 3327,
                'country_id' => 101,
                'state_id' => 33,
                'image' => null,
                'website' => null,
                'status' => 1,
                'apply_vender' => '0',
                'gender' => 'M',
                'remember_token' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
