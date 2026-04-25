<?php

namespace App\Http\Livewire;

use App\Models\BonDeCommande;
use App\Models\Paiement;
use Livewire\Component;

class BonCommandeComponent extends Component
{
    public $bon_commande_id = 0;

    public $bon_commande = [
        "num" => "loading",
        "date" => "loading",
        "etat" => "loading",
        'Remise' => "loading",
        'tva' => "loading",
        'taux' => "loading",
        'montant' => "loading",
        "client" => "loading",
        "delai" => "loading",
    ];

    public $bon_commande_article = [
        // "objectif" => "loading",
        "quantity"  => "loading",
        "designation"  => "loading",
    ];
    
    public $paiements = [];
    public function render()
    {
        $this->bon_commande_article = BonDeCommande::findOrFail($this->bon_commande_id)->articles;
        $this->paiements = Paiement::all();
        
        $this->bon_commande = BonDeCommande::findOrFail($this->bon_commande_id);
        return view('livewire.bon-commande-component');
    }

    public function mount($id)
    {
        $this->bon_commande_id = $id;
    }

    public function find($id)
    {
        $this->bon_commande = BonDeCommande::findOrFail($id);
    }
}
