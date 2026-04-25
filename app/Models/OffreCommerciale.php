<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OffreCommerciale extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'objectif',
        'montant',
        
    ];

 
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'offre_commerciale_article','offre_commerciales_id')->withPivot(['quantity','insertion_order'])->orderBy('pivot_insertion_order')->withTimestamps();
    }
}
