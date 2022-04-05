<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Inventory\Entities\ShowRoom::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
