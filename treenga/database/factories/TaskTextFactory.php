<?php

use Faker\Generator as Faker;

$factory->define(App\TaskText::class, function (Faker $faker) {
    return [
        'body' => $faker->realText(mt_rand(500, 2000)),
    ];
});
