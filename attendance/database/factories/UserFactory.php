<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'indexnumber' => $faker->numerify('GES#########'),
        'pro_pic' => $faker->randomElement(['profileimage/U14WFEWIKzphB2RQHG87EtTL2Tku5sRY9YnSpdoT.jpeg', 'profileimage/6dCWPFwMMZYiLA3GYY9G4YoB2tDnwtVVphLdrUwg.jpeg', 'profileimage/9JpKorHFtjE7aAKnORuJRofCObqr2xv9BV3dP14c.jpeg', 'profileimage/63waVDEDFyloOcfjKFqsV3hIwDsWCdwSQC7pFwaD.jpeg', 'profileimage/gsZQSs7C3czXbRTy3iv3U9EtmSa5peNKEbi3zbEk.jpeg', 'profileimage/IEdvJnudfpccaC5sGNKw1mlMrMNZgec9inOcb9pW.jpeg', 'profileimage/Jid8KPMfVEhpl6f8MN3CDdDXfwAvusxlKQSvxhzD.jpeg', 'profileimage/Nc0xja9O3BLbU3gcaF9lN6Ax0ppibdEXUvehksO1.jpeg', 'profileimage/NFYpqstKNuCkI2AKSyjTZb0UgttEX8NDDVvEZiIz.jpeg', 'profileimage/OLQpDuMTRR3Uuuekux2zgD5aHLF5gwNmEAs94baY.jpeg', 'profileimage/XhuAjdfm4MJPtCOX9Tuz4pIvd2OsThmR6K4N1MH5.jpeg']),
    ];
});
