<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Etat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projet>
 */
class ProjetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'objectif' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            // 'debut' => $this->faker->date($format = 'Y-m-d', $min='2023-01-01', $max = '2023-04-29'),
            // 'fin' => $this->faker->date($format = 'Y-m-d', $min='2023-04-30', $max = '2024-12-31'),
            'client_id' => Client::all()->random()->id,
            'montant' => $this->faker->numberBetween(1000, 90000),
            'delai' => $this->faker->numberBetween(20, 100),
            'type' => $this->faker->boolean(),
            'etat_id' => Etat::all()->random()->id
        ];
    }
}
