<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'facture_id',
        'quantity',
        'montant',
        'delai',
    ];
    protected $table = 'facture_article';
}
