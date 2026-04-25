<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FactureArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
        
                  
            'article_id' => Article::all()->random()->id, // Generating a random article ID
            'facture_id' => Facture::all()->random()->id, // Generating a random devis ID
            'quantity' => $this->faker->numberBetween(1,200),
            'delai' => $this->faker->numberBetween(1,20),
        ];
    }
}
