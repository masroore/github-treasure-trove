<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OptionValue;
use Faker\Generator as Faker;

$factory->define(OptionValue::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'sort_order' => $faker->numberBetween(1, 30),
    ];
});
