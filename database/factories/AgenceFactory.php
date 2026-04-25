<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agence>
 */
class AgenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => 'MyApp SARL (AU)',
            'gsm' => '+212 6 61 51 11 83',
            'fixe' => '+212 5 32 07 37 07',
            'site' => 'www.MyApp.com',
            'adresse' => 'Av Bir Anzarane Résidence Nour ter Etage Bureau 9 Centre Ville Fès',
            'email' => 'contact@MyApp.com',
            'logo'=> 'login-img.jpg',
            'Cachet'=> 'Cachet-img.jpg',
            'Signature'=> 'Signature-img.jpg',
            'ice'=> '000520780000060',
            'capital' => '100.000',
            'compte' => '21211 4972461 000 6',
            'rc' => '38795',
            'if'=> '40494350',
            'tp' => '14285038',
            'cnss' => '9167827'
        ];
    }
}
