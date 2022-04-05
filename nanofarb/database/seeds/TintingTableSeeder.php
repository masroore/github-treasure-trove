<?php

use App\Models\Shop\Attribute;
use Illuminate\Database\Seeder;

class TintingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('attributes')->insert([
            [
                'title' => Attribute::$purposes[Attribute::PURPOSE_TINTING_FACADE],
                'purpose' => Attribute::PURPOSE_TINTING_FACADE,
                'slug' => str_slug(Attribute::$purposes[Attribute::PURPOSE_TINTING_FACADE]),
            ],
            [
                'title' => Attribute::$purposes[Attribute::PURPOSE_TINTING_INTERIOR],
                'purpose' => Attribute::PURPOSE_TINTING_INTERIOR,
                'slug' => str_slug(Attribute::$purposes[Attribute::PURPOSE_TINTING_INTERIOR]),
            ],
        ]);
    }
}
