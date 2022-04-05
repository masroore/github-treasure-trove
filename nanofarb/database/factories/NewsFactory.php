<?php

use Faker\Generator as Faker;

$factory->define(App\Models\News::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-5 days');

    return [
        'name' => $faker->sentence(5),
        'body' => $faker->paragraph(22),
        'teaser' => $faker->paragraph(6),
        'publish' => 1,
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
