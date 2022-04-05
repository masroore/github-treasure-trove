<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Product\Entities\ModelType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(20),
        'status' => $faker->randomElement([0, 1]),
    ];
});
