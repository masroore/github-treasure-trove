<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Modules\AdminRbac\Models\AdminUserGroup;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => 'Admin',
        'last_name' => 'istrator',
        'email' => 'ssadmin@gmail.com',
        'username' => 'sadmin',
        'password' => bcrypt('123456'),
        'status' => 1,
    ];
});

$factory->afterCreating(App\User::class, function ($user, $faker): void {
    factory(AdminUserGroup::class)->create(['user_id' => 1, 'group_id' => 1]);
});
