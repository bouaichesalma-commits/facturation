<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonDeRetourArticle extends Model
{
    use HasFactory;
        use HasFactory;

    protected $table = 'bon_de_retour_article'; 
    protected $fillable = [
        'bon_de_retour_id',
        'article_id',
        'quantite',
        'prix_article',
    ];

    // Relation avec BonDeRetour
    public function bonDeRetour(): BelongsTo
    {
        return $this->belongsTo(BonDeRetour::class);
    }

    // Relation avec Article
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
