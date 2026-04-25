<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class NotificationComponent extends Component
{
    
    public $ClientWithDateExpiration = [
        "nom" => "loading",
        "DateExpiration" => "loading"
    ];
    public $countExprisation;
    public $client;

    public function render()
    {
        $this->ClientWithDateExpiration = Client::where('is_Expiration','=', 1)->orderBy('DateExpiration','desc')->get();
        $this->countExprisation = Client::where('is_Expiration','=', 1)->count();
        return view('livewire.notification-component');

    }
    public function removeNotification(){
        Client::where('is_Expiration','=',1)->update(['is_Expiration'=>null]);
        $this->ClientWithDateExpiration = Client::where('is_Expiration','=', 1)->orderBy('DateExpiration','desc')->get();
        $this->countExprisation = Client::where('is_Expiration','=', 1)->count();
        

    }
}


