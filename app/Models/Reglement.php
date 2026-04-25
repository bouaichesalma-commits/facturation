<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'facture_proforma_id',
        'bon_commande_fournisseur_id',
        'type_flux',
        'paiement_id',
        'montant',
        'num_cheque',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    public function factureProforma()
    {
        return $this->belongsTo(FactureProforma::class, 'facture_proforma_id');
    }

    public function bonCommandeFournisseur()
    {
        return $this->belongsTo(BonCommandeFournisseur::class, 'bon_commande_fournisseur_id');
    }

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}
