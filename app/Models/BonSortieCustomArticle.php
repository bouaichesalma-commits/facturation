<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonSortieCustomArticle extends Model
{
    use HasFactory;
     protected $table = 'bon_sortie_custom_articles';

    protected $fillable = [
        'bon_id',
        'name',
        'quantity',
        'prix',
        'insertion_order',
    ];

    public $timestamps = true;
}
