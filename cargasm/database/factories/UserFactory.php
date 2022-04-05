<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\User::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // passwor
        'name' => $name,
        'surname' => $faker->lastName,
        'nickname' => Str::slug($name),
        'role' => 'user',
        'status' => \App\Models\User::STATUS_APPROVED,
        'domain' => \App\Models\Domain::inRandomOrder()->first()->url,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
        'privacy' => [
            'fio' => 'true',
            'phone' => 'true',
            'email' => 'true',
        ],
        'social' => [
            'vk' => 'https://vk.com/' . Str::slug($name),
            'youtube' => '',
            'facebook' => 'https://www.facebook.com/' . Str::slug($name),
            'ok' => '',
        ],
    ];
});
