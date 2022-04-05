<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AbusedsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('abuseds')->delete();

        DB::table('abuseds')->insert([
            0 => [
                'id' => 1,
                'name' => 'foo',
                'rep' => '***',
                'status' => '1',
                'created_at' => null,
                'updated_at' => '2019-12-15 20:42:29',
            ],
        ]);
    }
}
