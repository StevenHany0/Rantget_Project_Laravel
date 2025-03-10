<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition()
    // {
    //     return [
    //         'id_identify' => $this->faker->randomNumber(8),
    //         'fullname' => $this->faker->unique()->name(),
    //         'email' => $this->faker->unique()->safeEmail(),
    //         'email_verified_at' => now(),
    //         'password' => bcrypt('12345678'), // Static password for all users
    //         'remember_token' => Str::random(10),
    //         'age' => $this->faker->numberBetween(21, 60),
    //         'phone' => $this->faker->numerify('01#########'), // 11-digit phone number
    //         'image' => $this->faker->imageUrl(),
    //         'id_identify_image' => $this->faker->imageUrl(),
    //         'role' => $this->faker->randomElement(['landlord', 'tenant']),
    //     ];
    // }
    public function definition()
    {
        return [
            'id_identify' => $this->faker->randomNumber(8),
            'fullname' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // Static password for all users
            'remember_token' => Str::random(10),
            'age' => $this->faker->numberBetween(21, 60),
            'phone' => $this->faker->numerify('01#########'), // 11-digit phone number
            'image' => asset('user_images/wvzaGjKDPloZuUKsnnKIKCsKIhsDldW4siVHzJLD.jpg'), // Static image
            'id_identify_image' => asset('id_identify_images/zgD55FZ9NzrDqTb0XS7jj5qbLkW7MOqhUp6n5wHT.jpg'),
            'role' => $this->faker->randomElement(['landlord', 'tenant']),
        ];
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
