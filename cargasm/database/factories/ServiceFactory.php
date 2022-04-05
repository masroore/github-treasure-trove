<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', 'now');
    $status = $faker->randomElement([Service::SERVICE_PUBLISHED, Service::SERVICE_MODERATE, Service::SERVICE_REJECTED]);
    $lang = $faker->randomElement(['ru', 'en']);

    if ($lang === 'ru') {
        $faker = \Faker\Factory::create('ru_RU');
    }

    $service = [
        'name' => $faker->company,
        'slug' => $faker->unique()->slug,
        'email' => $faker->email,
        'country' => $faker->country,
        'place' => $faker->city,
        'street' => $faker->streetName,
        'address' => $faker->address,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'working' => [
            [
                'days' => 'Пн-Пт',
                'time' => '10:00-19:00',
            ],
            [
                'days' => 'Сб',
                'time' => '10:00-18:00',
            ],
        ],
        'descr' => $faker->realText(mt_rand(300, 4000)),
        'service' => [
            'bodyRepair' => "$faker->boolean",
            'diagnostics' => "$faker->boolean",
            'runningGearRepair' => "$faker->boolean",
            'engineRepair' => "$faker->boolean",
            'transmissionRepair' => "$faker->boolean",
            'repairOfElectricalSystems' => "$faker->boolean",
            'tuning' => "$faker->boolean",
            'autoGlass' => "$faker->boolean",
            'carWashAndCare' => "$faker->boolean",
            'other' => "$faker->boolean",
        ],
        'social' => [
            'vk' => 'https://vk.com/feed',
            'youtube' => '',
            'facebook' => 'https://www.facebook.com',
            'ok' => '',
        ],
        'status' => $status,
        'msg_reject' => $status === Service::SERVICE_REJECTED ? $faker->realText(mt_rand(25, 200)) : null,
        'lang' => $lang,
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];

    return $service;
});
