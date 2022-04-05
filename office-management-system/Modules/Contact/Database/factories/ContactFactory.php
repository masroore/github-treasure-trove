<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\Modules\Contact\Entities\ContactModel::class, function (Faker $faker) {
    return [
        'contact_type' => $faker->randomElement(['Supplier', 'Customer']),
        'name' => $faker->name,
        'business_name' => $faker->firstName,
        'contact_id' => $faker->postcode,
        'tax_number' => $faker->ean8,
        'opening_balance' => $faker->numberBetween($min = 1000, $max = 9000),
        'pay_term' => $faker->creditCardType,
        'pay_term_condition' => $faker->randomElement(['Months', 'Days']),
        'customer_group' => 'None',
        'credit_limit' => 1000,
        'email' => $faker->email,
        'mobile' => $faker->phoneNumber,
        'alternate_contact_no' => $faker->phoneNumber,
        'division_id' => 1,
        'district_id' => 2,
        'upazila_id' => 19,
        'note' => "<p> $faker->text </p>",
        'avatar' => 'uploads/avatar/09-10-2020/5f8039ad4ba0e.png',
        'address' => $faker->address,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
