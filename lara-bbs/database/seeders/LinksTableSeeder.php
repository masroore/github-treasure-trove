<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    public function run(): void
    {
        Link::factory()->times(6)->create();
    }
}
