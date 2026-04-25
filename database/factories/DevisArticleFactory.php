<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Devis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DevisArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article_id' =>  Article::all()->random()->id, // Generating a random article ID
            'devis_id' => Devis::all()->random()->id, // Generating a random devis ID
            'quantity' => $this->faker->numberBetween(1,200),
        ];
    }
}
