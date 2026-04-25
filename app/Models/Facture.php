<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Projet;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facture extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'num',
        'date',
        'client_id',
        'paiement_id',
        'tva',
        'etat',
        'montant',
        'montantPaiy',
        'typeMpaiy',
        'numero_cheque',
        'remise',
        'etatremise'
     
    ];

 
    
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'facture_article')->withPivot(['quantity','insertion_order'])->orderBy('pivot_insertion_order')->withTimestamps();
    }

    public function customArticles()
{
    return $this->hasMany(CustomFactureArticle::class);
}

    public function reglements()
    {
        return $this->hasMany(Reglement::class);
    }

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
