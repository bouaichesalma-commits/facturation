<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonCommandeFournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'num', 
        'date',
        'fournisseur_id',
        'montant',
        'tva',
        'taux',
        'remise',
        'etatremise',
        'etat'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function articles()
    {
        return $this->hasMany(BonCommandeFournisseurArticle::class, 'bon_commande_fournisseur_id');
    }

    public function reglements()
    {
        return $this->hasMany(Reglement::class, 'bon_commande_fournisseur_id');
    }
}
