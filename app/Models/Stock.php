<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'Details',
   
        'prix_achat',
        'Quantite',
        'categorieproduit_id',
        'marque_id',
        'fournisseur_id',
    ];

    // Relationships

    public function categorieProduit()
    {
        return $this->belongsTo(CategorieProduit::class, 'categorieproduit_id');
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
}
