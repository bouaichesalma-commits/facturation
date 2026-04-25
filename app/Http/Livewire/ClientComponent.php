<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;
use App\Http\Requests\ClientRequest;

class ClientComponent extends Component
{
    public $client_id = 0;
    
    public $client = [
        "nom" => "loading",
        "email" => "loading",
        "tel" => "loading",
        "adresse" => "loading",
        "ice" => "loading"
    ];

    public function render()
    {
        return view('livewire.client-component');
    }

    public function mount($id)
    {
        $this->client_id = $id;
    }

    public function find($id)
    {
        $this->client = Client::findOrFail($id);
    }
}
