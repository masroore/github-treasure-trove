<?php
/*
 * File name: SlidesTableSeeder.php
 * Last modified: 2021.03.02 at 14:35:42
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('slides')->delete();

        DB::table('slides')->insert([
            0 => [
                'id' => 1,
                'order' => 1,
                'text' => 'Assign a Handyman at Work to Fix the Household',
                'button' => 'Discover It',
                'text_position' => 'bottom_start',
                'text_color' => '#333333',
                'button_color' => '#009E6A',
                'background_color' => '#FFFFFF',
                'indicator_color' => '#333333',
                'image_fit' => 'cover',
                'e_service_id' => null,
                'e_provider_id' => null,
                'enabled' => 1,
                'created_at' => '2021-01-25 11:51:45',
                'updated_at' => '2021-01-31 11:08:13',
            ],
            1 => [
                'id' => 2,
                'order' => 2,
                'text' => 'Fix the Broken Stuff by Asking for the Technicians',
                'button' => 'Repair',
                'text_position' => 'bottom_start',
                'text_color' => '#333333',
                'button_color' => '#F4841F',
                'background_color' => '#FFFFFF',
                'indicator_color' => '#333333',
                'image_fit' => 'cover',
                'e_service_id' => null,
                'e_provider_id' => null,
                'enabled' => 1,
                'created_at' => '2021-01-25 14:23:49',
                'updated_at' => '2021-01-31 11:03:05',
            ],
            2 => [
                'id' => 3,
                'order' => 3,
                'text' => 'Add Hands to Your Cleaning Chores',
                'button' => 'Book Now',
                'text_position' => 'bottom_start',
                'text_color' => '#333333',
                'button_color' => '#1FA3F4',
                'background_color' => '#FFFFFF',
                'indicator_color' => '#333333',
                'image_fit' => 'cover',
                'e_service_id' => null,
                'e_provider_id' => null,
                'enabled' => 1,
                'created_at' => '2021-01-31 11:04:36',
                'updated_at' => '2021-01-31 11:06:45',
            ],
        ]);
    }
}
