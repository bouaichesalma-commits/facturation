<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDevisArticle extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'quantity',
        'prix',
        'insertion_order',
        'devis_id'
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }
}
