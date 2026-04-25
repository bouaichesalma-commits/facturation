<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Projet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devis>
 */
class DevisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [ 
            'num' => $this->faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
            'date' => $this->faker->date($format = 'Y-m-d', $min='2023-01-01', $max = 'now'),
           // 'objectif' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'client_id' => Client::all()->random()->id,
            'tva' => $this->faker->randomElement([null, 'on']),
            'taux' => $this->faker->numberBetween(12, 20),
            'Remise' => $this->faker->numberBetween(12, 50),
            'montant' => $this->faker->numberBetween(2, 10000),
            'etat' => $this->faker->boolean(),
            //'delai' => $this->faker->numberBetween(20, 100),
        ];
    }
}
