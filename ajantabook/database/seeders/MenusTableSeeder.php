<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('menus')->delete();

        DB::table('menus')->insert([
            0 => [
                'id' => 1,
                'title' => '{"en":"Home"}',
                'icon' => 'fa-home',
                'link_by' => 'url',
                'cat_id' => null,
                'page_id' => null,
                'url' => 'http://localhost/publicdemo/public/',
                'position' => 1,
                'show_cat_in_dropdown' => 0,
                'linked_parent' => null,
                'show_child_in_dropdown' => 0,
                'linked_child' => null,
                'bannerimage' => null,
                'img_link' => null,
                'menu_tag' => 0,
                'tag_bg' => null,
                'tag_color' => null,
                'tag_text' => '{"en":null}',
                'show_image' => 0,
                'status' => 1,
            ],
            1 => [
                'id' => 2,
                'title' => '{"en":"Offer Zone"}',
                'icon' => 'fa-star-half-empty',
                'link_by' => 'cat',
                'cat_id' => 0,
                'page_id' => null,
                'url' => null,
                'position' => 2,
                'show_cat_in_dropdown' => 1,
                'linked_parent' => '["1","2","3"]',
                'show_child_in_dropdown' => 0,
                'linked_child' => '["1","2","3","7","8","9","4","5","6"]',
                'bannerimage' => null,
                'img_link' => null,
                'menu_tag' => 1,
                'tag_bg' => '#3be340',
                'tag_color' => '#ffffff',
                'tag_text' => '{"en":"Limited Time"}',
                'show_image' => 0,
                'status' => 1,
            ],
            2 => [
                'id' => 3,
                'title' => '{"en":"Deals In Electronics"}',
                'icon' => 'fa-bolt',
                'link_by' => 'cat',
                'cat_id' => 2,
                'page_id' => null,
                'url' => null,
                'position' => 3,
                'show_cat_in_dropdown' => 0,
                'linked_parent' => null,
                'show_child_in_dropdown' => 0,
                'linked_child' => null,
                'bannerimage' => null,
                'img_link' => null,
                'menu_tag' => 1,
                'tag_bg' => '#ff0505',
                'tag_color' => '#ffffff',
                'tag_text' => '{"en":"50 % off"}',
                'show_image' => 0,
                'status' => 1,
            ],
            3 => [
                'id' => 4,
                'title' => '{"en":"Fashion Hub"}',
                'icon' => 'fa-chain-broken',
                'link_by' => 'cat',
                'cat_id' => 3,
                'page_id' => null,
                'url' => null,
                'position' => 4,
                'show_cat_in_dropdown' => 0,
                'linked_parent' => null,
                'show_child_in_dropdown' => 0,
                'linked_child' => null,
                'bannerimage' => null,
                'img_link' => null,
                'menu_tag' => 1,
                'tag_bg' => '#ed078e',
                'tag_color' => '#ffffff',
                'tag_text' => '{"en":"New Collection !"}',
                'show_image' => 0,
                'status' => 1,
            ],
        ]);
    }
}
