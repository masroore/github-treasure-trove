<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductGallery;
use Faker\Generator as Faker;

$factory->define(ProductGallery::class, function (Faker $faker) {
    $imageNames = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '11.jpg'];

    return [
        'image' => $faker->randomElement($imageNames),
        'order' => $faker->numberBetween(1, 20),
    ];
});
