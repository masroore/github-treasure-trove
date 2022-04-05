<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DashboardSettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('dashboard_settings')->delete();

        DB::table('dashboard_settings')->insert([
            0 => [
                'id' => 1,
                'lat_ord' => 1,
                'rct_str' => 1,
                'rct_pro' => 1,
                'rct_cust' => 1,
                'max_item_ord' => '5',
                'max_item_str' => '5',
                'max_item_pro' => '5',
                'max_item_cust' => '3',
                'fb_wid' => 1,
                'tw_wid' => 1,
                'fb_page_id' => null,
                'fb_page_token' => null,
                'tw_username' => null,
                'inst_username' => null,
                'insta_wid' => 1,
                'created_at' => null,
                'updated_at' => '2019-10-23 15:33:46',
            ],
        ]);
    }
}
