<?php

namespace App\Http\Livewire;

use App\Models\FactureProforma;
use Livewire\Component;

class FactureProformaComponent extends Component
{


    public $factureProforma_id = 0;

    public $factureProforma = [
        "num" => "loading",
        "date" => "loading",
        "tva" => "loading",
        "objectif" => "loading",
        "etat" => "loading",
        "montant"=>"loading",
        // "client" => "loading"
    ];
    public  $facture_proforma_Article = [
        "designation"=>"loading",
        
      
    ];

    public $factureproforma_paiement = [
        "id" => "loading",
        "methode" => "loading"
    ];

    public function render()
    {
        $this->facture_proforma_Article['designation'] = FactureProforma::findOrFail($this->factureProforma_id)->articles;
        
    //    dd($this->facture_proforma_Article);

        $this->factureproforma_paiement = FactureProforma::findOrFail($this->factureProforma_id)->paiement;
        $this->factureProforma = FactureProforma::findOrFail($this->factureProforma_id);
        
        return view('livewire.facture-proforma-component');
    }

    public function mount($id)
    {
        $this->factureProforma_id = $id;
    }

    public function find($id)
    {
        $this->factureProforma = FactureProforma::findOrFail($id);
    }
    
}
