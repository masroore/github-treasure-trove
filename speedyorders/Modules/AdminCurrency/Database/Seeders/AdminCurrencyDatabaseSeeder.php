<?php

namespace Modules\AdminCurrency\Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AdminCurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 0; $i < 10; $i++) {
            Currency::create([
                'name' => \Str::random(10),
                'value' => rand(1, 100),
            ]);
        }
    }
}
