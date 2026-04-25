<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonArticle extends Model
{
    protected $table = 'bon_article';  
    
    protected $fillable = [
        'bon_de_livraison_id',
        'article_id',
        'quantite',
        'prix_article',
    ];

    public $timestamps = true; 
}
