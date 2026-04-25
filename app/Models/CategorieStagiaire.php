<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieStagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description'
    ];

    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class);
    }
}
