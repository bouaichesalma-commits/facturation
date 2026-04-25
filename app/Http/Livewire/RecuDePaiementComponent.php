<?php

namespace App\Http\Livewire;

use App\Models\RecuDePaiement;
use Livewire\Component;

class RecuDePaiementComponent extends Component
{

    public $RecuDePaiement_id = 0;

    public $RecuDePaiement = [
        "num" => "loading",
        "date" => "loading",
        "etat" => "loading",
        'Remise' => "loading",
        'tva' => "loading",
        'taux' => "loading",
        'montant' => "loading",
        "client" => "loading",
        "delai" => "loading",
        "objectif" => "loading",
    ];

    public $RecuDePaiement_article = [
        "quantity"  => "loading",
        "designation"  => "loading",
    ];
    

    public function render()
    {
        $this->RecuDePaiement_article = RecuDePaiement::findOrFail($this->RecuDePaiement_id)->articles;
        // dd($this->RecuDePaiement_article );
        $this->RecuDePaiement = RecuDePaiement::findOrFail($this->RecuDePaiement_id);
        return view('livewire.recu-de-paiement-component');
    }

    public function mount($id)
    {
        $this->RecuDePaiement_id = $id;
    }

    public function find($id)
    {
        $this->RecuDePaiement = RecuDePaiement::findOrFail($id);
    }
    
}
