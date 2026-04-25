<?php

namespace App\Http\Livewire;

use App\Models\Devis;
use App\Models\Paiement;
use Livewire\Component;

class DevisComponent extends Component
{
    public $devis_id = 0;

    public $devis = [
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

    public $devis_article = [
        // "objectif" => "loading",
        "quantity"  => "loading",
        "designation"  => "loading",
    ];
    
    public $paiements = [];
    public function render()
    {
        $this->devis_article = Devis::findOrFail($this->devis_id)->articles;
        // dd($this->devis_article );
        $this->paiements = Paiement::all();
        
        $this->devis = Devis::findOrFail($this->devis_id);
        return view('livewire.devis-component');
    }

    public function mount($id)
    {
        $this->devis_id = $id;
    }

    public function find($id)
    {
        $this->devis = Devis::findOrFail($id);
    }
}
