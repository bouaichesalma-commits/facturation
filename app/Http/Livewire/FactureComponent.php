<?php

namespace App\Http\Livewire;

use App\Models\Facture;
use Livewire\Component;

class FactureComponent extends Component
{
    public $facture_id = 0;

    public $facture = [
        "num" => "loading",
        "date" => "loading",
        "tva" => "loading",
        "objectif" => "loading",
        "etat" => "loading",
        "montant"=>"loading",
        // "client" => "loading"
    ];
    public  $facture_Article = [
        "designation"=>"loading",
        
      
    ];

    public $facture_paiement = [
        "id" => "loading",
        "methode" => "loading"
    ];

    public function render()
    {
        $this->facture_Article['designation'] = Facture::findOrFail($this->facture_id)->articles;
        
    //    dd($this->facture_Article);

        $this->facture_paiement = Facture::findOrFail($this->facture_id)->paiement;
        $this->facture = Facture::findOrFail($this->facture_id);
        return view('livewire.facture-component');
    }

    public function mount($id)
    {
        $this->facture_id = $id;
    }

    public function find($id)
    {
        $this->facture = Facture::findOrFail($id);
    }
}
