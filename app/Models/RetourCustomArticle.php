<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RetourCustomArticle extends Model
{
    use HasFactory;

   
    protected $table = 'retour_custom_articles';

    protected $fillable = [
        'bon_de_retour_id',
        'name',
        'quantity',
        'prix',
        'insertion_order',
    ];

   
    public function bonDeRetour(): BelongsTo
    {
        return $this->belongsTo(BonDeRetour::class);
    }
}
