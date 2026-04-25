<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvoirCustomArticle extends Model
{
    use HasFactory;

    protected $table = 'avoir_custom_articles';

    protected $fillable = [
        'avoir_id',
        'name',
        'quantity',
        'prix',
        'insertion_order',
    ];

    // Relation avec Avoir
    public function avoir(): BelongsTo
    {
        return $this->belongsTo(Avoir::class);
    }
}
