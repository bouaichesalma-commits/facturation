<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomProductFactureProforma extends Model
{
     use HasFactory;

    protected $table = 'custom_product_facture_proforma';

    protected $fillable = [
        'facture_proforma_id',
        'name',
        'quantity',
        'prix',
    ];

    public function factureProforma()
    {
        return $this->belongsTo(FactureProforma::class);
    }
}
