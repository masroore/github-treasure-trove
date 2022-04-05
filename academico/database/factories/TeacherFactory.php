<?php

use App\Models\Teacher;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Teacher::class, function (Faker $faker) {
    $user = factory(User::class)->create();

    return [
        'id' => $user->fresh()->id,
        'max_week_hours' => 25,
    ];
});
