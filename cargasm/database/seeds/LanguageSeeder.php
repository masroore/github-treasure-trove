<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
            'name' => 'English',
            'lang' => 'en',
        ]);
        Language::create([
            'name' => 'Русский',
            'lang' => 'ru',
        ]);
    }
}
