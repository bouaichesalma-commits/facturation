<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'tel' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'ice' => $this->faker->numberBetween(1000000000, 2000000000)
        ];
    }
}
