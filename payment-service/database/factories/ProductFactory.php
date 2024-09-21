<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
                'name' => $this->faker->company,  // Using Faker's company name as product name
                'description' => $this->faker->sentence,
                'price' => $this->faker->randomFloat(2, 10, 500),  // Random price between 10 and 500
                'quantity' => $this->faker->numberBetween(1, 100),   // Stock between 1 and 100
            ];
    }
}
