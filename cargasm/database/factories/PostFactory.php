<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-3 months', 'now');
    $author_type = $faker->randomElement(['App\Models\User', 'App\Models\Service']);
    $status = $faker->randomElement([Post::POST_PUBLISHED, Post::POST_UNPUBLISHED, Post::POST_MODERATE, Post::POST_REJECTED, Post::POST_DRAFT]);
    $user = \App\Models\User::inRandomOrder()->first();
    $userId = $user->id;
    $service = Service::where('status', Service::SERVICE_PUBLISHED)->get()->random();
    $lang = $faker->randomElement(['ru', 'en']);

    if ($lang === 'ru') {
        $faker = \Faker\Factory::create('ru_RU');
    }

    $post = [
        'title' => $faker->realText(mt_rand(15, 100)),
        'uuid' => $faker->uuid,
        'slug' => $faker->unique()->slug,
        'text' => $faker->realText(mt_rand(300, 5000)),
        'comment_allowed' => $faker->boolean,
        'status' => $status,
        'post_type' => ($user->role === \App\Models\User::ROLE_ADMIN && $author_type == 'App\Models\User')
            ? $faker->randomElement([Post::TYPE_NEWS, Post::TYPE_BLOG])
            : Post::TYPE_BLOG,
        'author_type' => $author_type,
        'author_id' => ($author_type == 'App\Models\User') ? $userId : $service->id,
        'msg_reject' => $status === Post::POST_REJECTED ? $faker->realText(mt_rand(25, 200)) : null,
        'lang' => $lang,
        'user_id' => ($author_type == 'App\Models\User') ? $userId : $service->user_id,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];

    return $post;
});
