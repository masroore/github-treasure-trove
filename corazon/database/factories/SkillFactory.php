<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'icon' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'difficulty' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'description' => $this->faker->text,
            'thumbnail' => $this->faker->word,
            'video' => $this->faker->text,
            'user_id' => User::factory(),
        ];
    }
}
