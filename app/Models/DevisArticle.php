<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisArticle extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'devis_id',
        'quantity',
    ];
    protected $table = 'devis_article';
}
