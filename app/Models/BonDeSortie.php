<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonDeSortie extends Model
{
    use HasFactory;

    protected $table = 'bon_de_sortie';

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

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'bon_sortie_article', 'bon_de_sortie_id', 'article_id')
                    ->withPivot('quantite', 'prix_article')
                    ->withTimestamps();
    }
}
