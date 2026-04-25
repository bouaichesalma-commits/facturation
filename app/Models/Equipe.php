<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class equipe extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    use Notifiable;
    
    protected $fillable = [
        'name',
        'categorieequipe_id',
        'telephone',
        'email',
        'adresse',
        'cv_path',
        'demande_stage_path',
        'portfolio_link',
        'description'
    ];
    public function categorieequipe()
    {
        return $this->belongsTo(CategorieEquipe::class);
    }
}
