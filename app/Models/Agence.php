<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nom',
        'gsm',
        'fixe',
        'site',
        'adresse',
        'email',
        'logo',
        'signature',  
        'cachet'  ,
        'ice',
        'capital',
        'compte',
        'banque',
        'rc',
        'if',
        'tp',
        'cnss'
    ];
}
