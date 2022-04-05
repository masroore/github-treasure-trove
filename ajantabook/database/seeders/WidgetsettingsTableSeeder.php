<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class WidgetsettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('widgetsettings')->delete();

        DB::table('widgetsettings')->insert([
            0 => [
                'id' => 1,
                'name' => 'category',
                'home' => '1',
                'shop' => '0',
            ],
            1 => [
                'id' => 2,
                'name' => 'hotdeals',
                'home' => '1',
                'shop' => '1',
            ],
            2 => [
                'id' => 3,
                'name' => 'specialoffer',
                'home' => '1',
                'shop' => '0',
            ],
            3 => [
                'id' => 4,
                'name' => 'testimonial',
                'home' => '1',
                'shop' => '0',
            ],
            4 => [
                'id' => 5,
                'name' => 'newsletter',
                'home' => '1',
                'shop' => '1',
            ],
            5 => [
                'id' => 6,
                'name' => 'slider',
                'home' => '1',
                'shop' => '0',
            ],
        ]);
    }
}
