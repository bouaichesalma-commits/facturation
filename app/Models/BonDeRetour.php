<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonDeRetour extends Model
{
    use HasFactory;

    protected $table = 'bon_de_retour';

    protected $fillable = [
        'num',
        'date',
        'client_id',
        'montant',
        'type',
        'remise',
        'etatremise',
        'etat_id',
        'tva',
        'taux'
    ];

    // Relation avec Client
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // Relation avec Articles pivot
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(
            Article::class,
            'bon_de_retour_article',
            'bon_de_retour_id',
            'article_id'
        )
        ->withPivot('quantite', 'prix_article')
        ->withTimestamps();
    }

        public function customArticles(): HasMany
    {
        return $this->hasMany(RetourCustomArticle::class);
    }


}
