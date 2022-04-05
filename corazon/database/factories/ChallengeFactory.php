<?php

namespace Database\Factories;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallengeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Challenge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'video' => $this->faker->text,
            'thumbnail' => $this->faker->imageUrl(640, 640),
            'user_id' => User::factory(),
            'difficulty' => $this->faker->randomElement(['easy', 'moderate', 'difficult']),
        ];
    }
}
