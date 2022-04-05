<?php

namespace Modules\AdminCurrency\Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Str;

class AdminCurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        for ($i = 0; $i < 10; ++$i) {
            Currency::create([
                'name' => Str::random(10),
                'value' => mt_rand(1, 100),
            ]);
        }
    }
}
