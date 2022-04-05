<?php

namespace Database\Seeders;

use App\Models\Target;
use Illuminate\Database\Seeder;

class AddTargetNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop over the targets
        $targets = Target::all();

        foreach ($targets as $target) {
            $target->name = $target->target_name;
            $target->save();
        }
    }
}
