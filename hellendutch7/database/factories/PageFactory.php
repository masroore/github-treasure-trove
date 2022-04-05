<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'featured_img' => $this->faker->url,
            'title' => $this->faker->name(2),
            'name' => $this->faker->name(3),
            'slug' => 'asde-assde-asde',
            'owner_id' => Auth::id(),
        ];
    }
}
