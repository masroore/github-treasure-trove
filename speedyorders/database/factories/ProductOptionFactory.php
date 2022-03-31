<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Option;
use App\Models\ProductOption;
use Faker\Generator as Faker;

$factory->define(ProductOption::class, function (Faker $faker) {
    $optionIds = Option::all()->pluck('id');

    return [
        'option_id'=>$faker->randomElement($optionIds),
        'required'=>$faker->boolean(100),
    ];
});
