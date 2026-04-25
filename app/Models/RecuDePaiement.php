<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecuDePaiement extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'num',
        'date',
        'tva',
        'taux',
        'etat',
        'objectif',
        'client_id',
        'montant',
        'delai',
        'type',
        'remise',
        'etatremise'
        
    ];

 
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'recu_de_paiement_articles')->withPivot(['quantity','insertion_order'])->orderBy('pivot_insertion_order')->withTimestamps();
    }
}
