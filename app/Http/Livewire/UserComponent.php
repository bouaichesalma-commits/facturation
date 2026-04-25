<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserComponent extends Component
{
    
    public $user_id = 0;
    
    public $user = [
        "name" => "loading",
        "email" => "loading",
        "tel" => "loading",
        "adresse" => "loading",
        "ice" => "loading"
    ];

    public function render()
    {
        return view('livewire.user-component');
    }

    public function mount($id)
    {
        $this->user_id = $id;
    }

    public function find($id)
    {
        $this->user = User::findOrFail($id);
    }
}
