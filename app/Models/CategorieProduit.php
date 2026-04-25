<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieProduit extends Model
{
    use HasFactory;
    protected $table = 'categorieproduits';
    protected $fillable = [
        'categorie',
    ];


    // Define the inverse relationship between CategorieProduit and Article
    public function articles()
    {
        return $this->hasMany(Article::class, 'categorieproduit_id');
    }
}
