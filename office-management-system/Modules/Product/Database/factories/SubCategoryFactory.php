<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Product\Entities\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => $faker->postcode,
        // "parent_id" => rand(1,35),
        'description' => $faker->text(20),
        'status' => $faker->randomElement([0, 1]),
    ];
});
