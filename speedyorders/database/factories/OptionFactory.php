<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Option;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => 'select',
        'sort_order' => $faker->numberBetween(1, 50),
    ];
});
