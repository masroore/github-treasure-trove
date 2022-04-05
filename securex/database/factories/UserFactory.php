<?php

namespace Database\Factories;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

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
            'first_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user has two factor authentication secret code.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function tfa_key()
    {
        return $this->state(function (array $attributes) {
            $tfa = new Google2FA();

            return [
                'two_factor_secret' => encrypt($tfa->generateSecretKey(16)),
            ];
        });
    }
}
