<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class LocalesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('locales')->delete();

        DB::table('locales')->insert([
            0 => [
                'id' => 1,
                'lang_code' => 'en',
                'name' => 'English',
                'def' => 1,
                'status' => 1,
            ],
            1 => [
                'id' => 2,
                'lang_code' => 'hi',
                'name' => 'Hindi',
                'def' => 0,
                'status' => 1,
            ],
            2 => [
                'id' => 3,
                'lang_code' => 'es',
                'name' => 'Spanish',
                'def' => 0,
                'status' => 1,
            ],
        ]);
    }
}
