<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipe_id',
        'categorieproject_id',
        'categorie_attestation_id',
        'start_date',
        'end_date',
        'signature_date',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function categorieproject()
    {
        return $this->belongsTo(CategorieProjects::class);
    }

    public function categorieAttestation()
    {
        return $this->belongsTo(CategorieAttestation::class);
    }
}
