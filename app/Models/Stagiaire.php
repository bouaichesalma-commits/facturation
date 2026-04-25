<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'categorie_id',    // Ajout du champ categorie_id
        'telephone',
        'email',
        'adresse',         // Ajout du champ adresse
        'portfolio_link',
        'cv_path',
        'demande_stage_path',
        'description',     // Ajout du champ description
    ];

    public function categorieStagiaire()
    {
        return $this->belongsTo(CategorieStagiaire::class, 'categorie_id'); // Lien avec la table des catégories
    }
}
