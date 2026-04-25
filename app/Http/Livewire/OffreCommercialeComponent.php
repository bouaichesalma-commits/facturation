<?php

namespace App\Http\Livewire;

use App\Models\OffreCommerciale;
use Livewire\Component;

class OffreCommercialeComponent extends Component
{
    

    public $OffreCommerciale_id = 0; 

    public $OffreCommerciale = [
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

    public $OffreCommerciale_article = [
        "quantity"  => "loading",
        "designation"  => "loading",
    ];
    

    public function render()
    {
        $this->OffreCommerciale_article = OffreCommerciale::findOrFail($this->OffreCommerciale_id)->articles;
        // dd($this->OffreCommerciale_article );
        $this->OffreCommerciale = OffreCommerciale::findOrFail($this->OffreCommerciale_id);
        return view('livewire.offre-commerciale-component');
    }

    public function mount($id)
    {
        $this->OffreCommerciale_id = $id;
    }

    public function find($id)
    {
        $this->OffreCommerciale = OffreCommerciale::findOrFail($id);
    }
}
