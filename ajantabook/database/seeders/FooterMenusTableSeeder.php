<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class FooterMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('footer_menus')->delete();

        DB::table('footer_menus')->insert([
            0 => [
                'id' => 1,
                'title' => '{"en":"Privacy Policy"}',
                'link_by' => 'page',
                'position' => '2',
                'widget_postion' => 'footer_wid_3',
                'page_id' => 1,
                'url' => null,
                'status' => 1,
            ],
            1 => [
                'id' => 2,
                'title' => '{"en":"Terms of services"}',
                'link_by' => 'page',
                'position' => '2',
                'widget_postion' => 'footer_wid_3',
                'page_id' => 2,
                'url' => null,
                'status' => 1,
            ],
        ]);
    }
}
