<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'property_id' => \App\Models\Property::factory(),
            'landlord_id' => \App\Models\User::factory()->state(['role' => 'landlord']),
            'tenant_id' => \App\Models\User::factory()->state(['role' => 'tenant']),
            'start_date' => $this->faker->date(),
            // 'contract_image' => 'contract_image/static-image.jpg', // Ensure the image is in storage
            'end_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 500, 10000),
        ];
    }
}
