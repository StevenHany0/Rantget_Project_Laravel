<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'image' => 'properties_images/0t9hPJhHwmgXRrflszquzOlZC7FAdwCuM176boig.jpg', // Ensure the image is in storage
            'location' => $this->faker->address(),
            'price' => $this->faker->randomFloat(2, 500, 10000), // Between 500 and 10000
            'status' => $this->faker->randomElement(['unavailable', 'reserved', 'available', 'rent']),
            // 'landlord_id' => User::factory(), // Corrected namespace
        ];
    }
}
