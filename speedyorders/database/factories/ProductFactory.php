<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'sku' => $faker->ean13,
        'name' => $faker->name,
        'length' => $faker->numberBetween(1, 50),
        'breadth' => $faker->numberBetween(1, 50),
        'height' => $faker->numberBetween(1, 50),
        'width' => $faker->numberBetween(1, 50),
        'description' => $faker->text,
        'base_price' => $faker->randomFloat(2, 0, 2000),
        'quantity' => $faker->numberBetween(1),
        'min_quantity' => $faker->numberBetween(1, 50),
        'subtract_stock' => $faker->boolean(200),
        'sort_order' => $faker->numberBetween(1, 20),
        'status' => $faker->numberBetween(0, 1),
        'trending' => $faker->numberBetween(0, 1),
        'is_featured' => $faker->numberBetween(0, 1),
        'meta_title' => $faker->name,
        'meta_description' => $faker->text,
    ];
});
