<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\Projet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'designation',
        'prix',

        'Details',

        'categorieproduit_id',
        'marque_id',
        'fournisseur_id'
    ];


    // Define the relationship between Article and CategorieProduit
    public function categorieProduit()
    {
        return $this->belongsTo(CategorieProduit::class, 'categorieproduit_id');
    }

    public function devis(): BelongsToMany
    {
        return $this->belongsToMany(Devis::class, 'devis_article')->withPivot(['quantity']);
    }
    public function BonDeLivraison()
    {
        return $this->belongsToMany(BonDeLivraison::class, 'bon_article', 'article_id', 'bon_de_livraison_id')
            ->withPivot('quantite', 'prix_article')
            ->withTimestamps();
    }

    public function bonDeRetours()
    {
        return $this->belongsToMany(
            BonDeRetour::class,
            'bon_de_retour_article',
            'article_id',
            'bon_de_retour_id'
        )
            ->withPivot('quantite', 'prix_article')
            ->withTimestamps();
    }


    public function avoirs(): BelongsToMany
{
    return $this->belongsToMany(
        Avoir::class,
        'avoir_article',  
        'article_id',     
        'avoir_id'        
    )
    ->withPivot('quantite', 'prix_article')
    ->withTimestamps();
}




    public function factures(): BelongsToMany
    {
        return $this->belongsToMany(Facture::class, 'facture_article')->withPivot(['quantity']);
    }


    public function factureproformas(): BelongsToMany
    {
        return $this->belongsToMany(FactureProforma::class, 'facture_proforma_articles', 'facture_proforma_id')->withPivot(['quantity']);
    }

    public function recudepaiements(): BelongsToMany
    {
        return $this->belongsToMany(RecuDePaiement::class, 'recu_de_paiement_articles', 'recu_de_paiement_id')->withPivot(['quantity']);
    }

    public function offrecommerciales(): BelongsToMany
    {

        return $this->belongsToMany(OffreCommerciale::class, 'offre_commerciale_article', 'offre_commerciales_id')->withPivot(['quantity']);
    }



    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }



}
