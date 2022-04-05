<?php

use App\Collection;
use App\Post;

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make($faker->password),
        'permission' => 7,
    ];
});

$factory->define(Collection::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'user_id' => User::first()->id,
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber,
        'title' => $faker->title,
        'content' => $faker->sentence,
        'collection_id' => (Collection::count() > 0) ? Collection::first()->id : null,
        'type' => Post::POST_TYPE_TEXT,
        'user_id' => User::first()->id,
        'order' => Post::where('collection_id', null)->count(),
    ];
});
