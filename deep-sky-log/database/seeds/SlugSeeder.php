<?php

namespace Database\Seeders;

use App\Models\TargetName;
use App\Models\User;
use Illuminate\Database\Seeder;

class SlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop over the users
        $users = User::all();

        foreach ($users as $user) {
            // Add the slugs to the users
            $user->save();
        }

        // Loop over the targetnames
        $targetnames = TargetName::all();

        foreach ($targetnames as $targetname) {
            // Add the slugs to the users
            $targetname->save();
        }
    }
}
