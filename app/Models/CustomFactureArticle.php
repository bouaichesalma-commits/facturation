<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFactureArticle extends Model
{
    use HasFactory;
    protected $table = 'custom_facture_articles';

    protected $fillable = [
        'facture_id',
        'name',
        'quantity',
        'prix',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
