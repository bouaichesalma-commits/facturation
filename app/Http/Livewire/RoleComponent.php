<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleComponent extends Component
{ 
    public $role_id = 0;
    
    public $role = [
        "name" => "loading",
        "email" => "loading",
        "tel" => "loading",
        "adresse" => "loading",
        "ice" => "loading"
    ];
    public function render()
    {
        return view('livewire.role-component');
    }
    
    public function mount($id)
    {
        $this->role_id = $id;
    }

    public function find($id)
    {
        $this->role = Role::findOrFail($id);
    }
}
