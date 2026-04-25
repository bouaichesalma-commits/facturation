<?php

namespace App\Models;

use App\Models\Devis;
use App\Models\Projet;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    use Notifiable;
    
    protected $fillable = [
        'nom',
        'nom_societe',
        'email',
        'tel',
        'adresse',
        'ice',
        'DateExpiration',
        'etatDateExp'
    ];

    

    public function devis(): HasMany
    {
        return $this->hasMany(Devis::class);
    }

   
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class);
    }
}
