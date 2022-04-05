<?php

use App\Models\Domain;
use App\Models\Language;
use Illuminate\Database\Seeder;

class AttachLanguageForDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::all();

        foreach (Domain::all() as $domain) {
            $domain->languages()->syncWithoutDetaching($languages->pluck('id')->toArray());
        }
    }
}
