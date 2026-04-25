<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonSortieArticle extends Model
{
    use HasFactory;
      protected $table = 'bon_sortie_article';

    protected $fillable = [
        'bon_de_sortie_id',
        'article_id',
        'quantite',
        'prix_article',
    ];

    public $timestamps = true;
}
