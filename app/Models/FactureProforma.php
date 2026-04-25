<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FactureProforma extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'num',
        'date',
        'client_id',
        'paiement_id',
        'tva',
        'objectif',
        'etat',
        'montant',
        'montantPaiy',
        'typeMpaiy',
        'remise',
        'etatremise'
    
    ];

 
    
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'facture_proforma_articles')->withPivot(['quantity','insertion_order'])->orderBy('pivot_insertion_order')->withTimestamps();
    }

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function customProducts()
    {
        return $this->hasMany(CustomProductFactureProforma::class);
    }
    
    public function reglements()
    {
        return $this->hasMany(Reglement::class);
    }
}
