<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address_1' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
            'lat' => $this->faker->latitude(),
            'lng' => $this->faker->longitude(),
            'country_id' => $this->faker->numberBetween(1,10)

        ];
    }
}
