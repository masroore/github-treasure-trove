<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Studentinfo;
use Faker\Generator as Faker;

$factory->define(Studentinfo::class, function (Faker $faker) {
    return [
        'gender' => $faker->randomElement(['Male', 'Female']),
        'dateofbirth' => '02-06-1992',
        'religion' => $faker->randomElement(['Christian', 'Muslem']),
        'denomination' => 'Penticost',
        'placeofbirth' => $faker->dayOfMonth,
        'nationality' => $faker->country,
        'hometown' => $faker->state,
        'region' => '',
        'disability' => $faker->randomElement(['Disabled', 'No']),
        'postcode' => $faker->postcode,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'maritalstutus' => $faker->randomElement(['Married', 'Single', 'Divorced']),
        'entrylevel' => $faker->randomElement(['Level 100', 'Level 200', 'Level 300', 'Level 400']),
        'currentlevel' => $faker->randomElement(['Level 100', 'Level 200', 'Level 300', 'Level 400']),
        'session' => $faker->randomElement(['Morning Session', 'Evening Session', 'Weekend Session']),
        'programme' => $faker->randomElement(['Bachelor of Science  in Information Technology Management', 'Bachelor of Arts in Public Relations Management', 'Diploma in Accounting']),
        'type' => $faker->randomElement(['Degree Programme', 'Diploma Programme']),
        'gurdianname' => $faker->name,
        'relationship' => 'Mother',
        'occupation' => 'Student',
        'mobile' => $faker->phoneNumber,
        'employed' => $faker->randomElement(['Yes', 'No']),
        'status' => 1,
        'academic_year' => '2020-2021',
        'admitted' => 'AUG,' . date('Y'),
        'completion' => 'AUG2022',
    ];
});
