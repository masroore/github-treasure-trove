<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    $categoryIds = Category::all()->pluck('id');

    return [
        'category_id' => $faker->randomElement($categoryIds),
        'status' => $faker->numberBetween(0, 1),
    ];
});
