<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonCommandeFournisseurArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'bon_commande_fournisseur_id',
        'article_id',
        'produit',
        'quantite',
        'prix'
    ];

    public function bonCommandeFournisseur()
    {
        return $this->belongsTo(BonCommandeFournisseur::class, 'bon_commande_fournisseur_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
