<?php

namespace Database\Factories;

use App\Models\Product;
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
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraphs(3, true),
            'video' => $this->faker->text,
            'thumbnail' => $this->faker->word,
            'qty' => $this->faker->numberBetween(-10000, 10000),
            'price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'dealine' => $this->faker->dateTime(),
        ];
    }
}
