<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Projet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Devis extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'num',
        'date',
        'tva',
        'taux',
        'etat',
        'client_id',
        'montant',
        'type',
        'nom_commercial',
        'remise',
        'etatremise'
        
    ];

 
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'devis_article')->withPivot(['quantity', 'prix', 'insertion_order'])->orderBy('pivot_insertion_order')->withTimestamps();
    }

    public function customArticles()
{
    return $this->hasMany(CustomDevisArticle::class);
}

}
