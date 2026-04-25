<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'client_id',
        'equipe_id',
        'categorieproject_id',
        'start_date',
        'end_date',
        'description',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function categorieproject()
    {
        return $this->belongsTo(CategorieProjects::class, 'categorieproject_id');
    }
}
