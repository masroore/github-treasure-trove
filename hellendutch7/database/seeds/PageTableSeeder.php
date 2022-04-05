<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pages')->insert([
            'name' => 'About Me',
            'slug' => 'about-me',
            'title' => 'Hellen Dutch',
            'owner_id' => 1,
        ]);

        DB::table('pages')->insert([
            'name' => 'Why Borneo',
            'slug' => 'why-borneo',
            'title' => 'Why Borneo',
            'owner_id' => 1,
        ]);

        DB::table('pages')->insert([
            'name' => 'Use of Materials',
            'slug' => 'use-of-materials',
            'title' => 'Use of Materials',
            'owner_id' => 1,
        ]);
    }
}
