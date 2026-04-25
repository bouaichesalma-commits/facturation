<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class NotificationClientController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $clientDatExp = Client::where('is_Expiration','=',1)->get();
        return view('Notification.index',compact('clientDatExp'));
    }

}
