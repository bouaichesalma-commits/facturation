<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designation' => $this->faker->sentence(),
            'Details' => $this->faker->sentence(),
            'role' => $this->faker->randomElement(['service', 'produit']),
            'Quantite' => $this->faker->numberBetween(1, 200),
            'prix' => $this->faker->numberBetween(100, 10000)
        ];
    }
}
