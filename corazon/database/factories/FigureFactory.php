<?php

namespace Database\Factories;

use App\Models\Figure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FigureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Figure::class;

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
            'thumbnail' => $this->faker->word,
            'difficulty' => $this->faker->word,
            'user_id' => User::factory(),
        ];
    }
}
