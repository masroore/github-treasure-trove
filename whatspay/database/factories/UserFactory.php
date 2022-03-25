<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_type' => 'company',
            'user_status' => 1,
            'country_code' => $this->faker->countryCode(),
            'wp_num_inc_code' => $this->faker->e164PhoneNumber(),
            'wp_num_exc_code' => $this->faker->e164PhoneNumber(),
            'activation_code' => '$2y$10$CO3s9P/nzX/D9aEq/XW5VOGJ4glM6nUTeCZinwktEZF8kTmsYBeRS',
            'activation_key' => '$2y$10$Y47rPSJB4lsUCkrGrCJrWu8XU72zwyEXPUQmb8pijJmxAEZWIAntS',
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '$2y$10$snSrO6ab2TmbCFWG.u9dq.wS.wYSE8WHjZ7LL37rQ3kycxgQKRR3y',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
