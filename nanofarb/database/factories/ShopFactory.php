<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Shop\Product::class, function (Faker $faker) {
    $price = mt_rand(1, 10000) * 100;
    $price_old = $faker->randomElement([$price + mt_rand(0, 200) * 100, 0]);

    $date = $faker->dateTimeBetween('-1 year');

    return [
        'name' => $faker->sentence(5),
        'description' => $faker->paragraph(12),
        'sku' => $faker->isbn13,
        'price' => $price,
        'price_old' => $price_old,
        'currency' => config('currency.default', 'RUB'),
        'publish' => 1,
        //'rating' => rand(1, 1000),
        'data' => [
            'applying' => $faker->paragraph(5),
            'instruction' => $faker->paragraph(6),
        ],
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

$factory->define(App\Models\Shop\Order::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-1 year');
    $user = \App\Models\User::whereHas('contacts')->inRandomOrder()->first();

    return [
        'status' => \Fomvasss\Taxonomy\Models\Term::byVocabulary('order_statuses')->inRandomOrder()->first()->system_name,
        'payment_status' => \Fomvasss\Taxonomy\Models\Term::byVocabulary('payment_statuses')->inRandomOrder()->first()->system_name,
        'ip' => $faker->ipv4,
        'user_id' => $user->id,
        'data' => ['delivery' => $user->contacts->random()->toArray(), 'payment' => ['method' => 'upon_receipt']],
        'created_at' => $date,
        'updated_at' => $date,
        'ordered_at' => $date,
    ];
});

$factory->define(App\Models\Shop\ProductReview::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-1 year')/*->format('Y-m-d H:i:s')*/;

    return [
        'status' => 1,
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'product_id' => \App\Models\Shop\Product::inRandomOrder()->first()->id,
        'body' => $faker->paragraph(mt_rand(2, 5)),
        'rating' => mt_rand(1, 5),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

$factory->define(App\Models\Shop\Sale::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-1 year');
    $days = mt_rand(1, 50);
    $endDays = $days + mt_rand(10, 50);
    $startAt = $faker->dateTimeInInterval("-$days days", "$days days");
    $endAt = $faker->dateTimeInInterval("$days days", "$endDays days");
    $discountType = mt_rand(1, 2);

    return [
        'name' => $faker->city,
        'publish' => 1,
        'description' => $faker->paragraph(mt_rand(12, 15)),
        'discount_type' => $discountType,
        'discount' => $discountType == 1 ? mt_rand(15, 80) : mt_rand(50000, 400000),
        'type' => $faker->randomElement(array_keys(\App\Models\Shop\Sale::$types)),
        'dateless' => mt_rand(0, 1),
        'start_at' => $startAt,
        'end_at' => $endAt,
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
