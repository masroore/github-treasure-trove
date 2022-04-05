<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        ];
    }
}
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,

    ];
}); /** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Post::class, static function (Faker\Generator $faker) {
    return [
        'post_name' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'surname' => $faker->lastName,
        'first_name' => $faker->firstName,
        'second_name' => $faker->sentence,
        'passport_series' => $faker->sentence,
        'passport_number' => $faker->sentence,
        'inn' => $faker->sentence,
        'scan' => $faker->sentence,
        'birthday' => $faker->date(),
        'deleted' => $faker->boolean(),
        'dismissed' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'api_token' => $faker->sentence,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\City::class, static function (Faker\Generator $faker) {
    return [
        'city_name' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Office::class, static function (Faker\Generator $faker) {
    return [
        'phone' => $faker->sentence,
        'address' => $faker->sentence,
        'city_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Route::class, static function (Faker\Generator $faker) {
    return [
        'departure_city_id' => $faker->sentence,
        'arrival_city_id' => $faker->sentence,
        'distance' => $faker->sentence,
        'user_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Model::class, static function (Faker\Generator $faker) {
    return [
        'model_name' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Transport::class, static function (Faker\Generator $faker) {
    return [
        'car_number' => $faker->sentence,
        'total_seats' => $faker->boolean(),
        'model_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Schedule::class, static function (Faker\Generator $faker) {
    return [
        'date' => $faker->date(),
        'time' => $faker->time(),
        'cost' => $faker->randomNumber(5),
        'confirmed' => $faker->boolean(),
        'transport_id' => $faker->sentence,
        'route_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Passenger::class, static function (Faker\Generator $faker) {
    return [
        'surname' => $faker->lastName,
        'first_name' => $faker->firstName,
        'second_name' => $faker->sentence,
        'passport_series' => $faker->sentence,
        'passport_number' => $faker->sentence,
        'phone' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Ticket::class, static function (Faker\Generator $faker) {
    return [
        'passenger_id' => $faker->sentence,
        'schedule_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\PostUser::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'post_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\OfficeUser::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'office_id' => $faker->sentence,
        'deleted' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,

    ];
});
