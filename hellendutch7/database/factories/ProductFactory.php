<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'featured_img' => $this->faker->url,
            'title' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['For Sale', 'Sold', 'Not for Sale']),
            'price' => $this->faker->numberBetween(12300, 50000),
            'discount' => 'Yes',
            'owner_id' => User::factory()->create()->id,
            'likes' => $this->faker->numberBetween(10, 50),
            'publish_at' => $this->faker->date,
        ];
    }
}
