<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Avoir extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model
    protected $table = 'avoir';

    // Fillable fields for mass assignment
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

    // Relationship with Client
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }


    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(
            Article::class,
            'avoir_article',
            'avoir_id',
            'article_id'
        )
            ->withPivot('quantite', 'prix_article')
            ->withTimestamps();
    }

    public function customArticles()
    {
        return $this->hasMany(AvoirCustomArticle::class);
    }
}
