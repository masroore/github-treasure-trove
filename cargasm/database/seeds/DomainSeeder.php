<?php

use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domains = explode(',', env('SEED_DOMAINS'));
        foreach ($domains as $domain) {
            Domain::firstOrCreate(['url' => $domain]);
        }
    }
}
