<?php

namespace Modules\Leave\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Leave\Entities\Holiday;

class HolidayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        Holiday::truncate();

        Holiday::create(['year' => Carbon::now()->year]);
    }
}
