<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'store_name' => $this->faker->company(),
            'whatsapp_num' => $this->faker->e164PhoneNumber(),
            'business_url' => $this->faker->domainWord(),
            'industry_id' => 0,
            'industry_types' => null,
            'description' => $this->faker->paragraph(3),
            'images' => $this->faker->imageUrl(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'street_address' => $this->faker->streetAddress(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'country' => $this->faker->country(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'mobile_number' => $this->faker->e164PhoneNumber(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'created_at' => now(),
            'updated_at' => now(),
            'iban_number' => $this->faker->iban(),
            'swift_code' => $this->faker->swiftBicNumber(),
            'currency' => $this->faker->currencyCode(),
            'shipping_percentage_type' => 'flat',
            'status' => 1,
        ];
    }
}
