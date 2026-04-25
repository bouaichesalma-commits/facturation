<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AvoirArticle extends Model

{
    use HasFactory;
     protected $table = 'avoir_article';

    protected $fillable = [
        'avoir_id',
        'article_id',
        'quantite',
        'prix_article',
    ];

    public function avoir(): BelongsTo
    {
        return $this->belongsTo(Avoir::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

}
