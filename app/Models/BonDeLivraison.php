<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BonDeLivraison extends Model
{
    use HasFactory;
    protected $table = 'bon_de_livraisons';

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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
   public function articles()
{
    return $this->belongsToMany(Article::class, 'bon_article', 'bon_de_livraison_id', 'article_id')
                ->withPivot('quantite', 'prix_article')
                ->withTimestamps();
}

}
