<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SpecialOfferWidgetTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('special_offer_widget')->delete();

        DB::table('special_offer_widget')->insert([
            0 => [
                'id' => 1,
                'slide_count' => '3',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
