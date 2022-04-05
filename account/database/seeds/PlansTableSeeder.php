<?php

use App\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create(
            [
                'name' => 'Free Plan',
                'price' => 0,
                'duration' => 'Unlimited',
                'max_users' => 5,
                'max_customers' => 5,
                'max_venders' => 5,
                'image' => 'free_plan.png',
            ]
        );
    }
}
