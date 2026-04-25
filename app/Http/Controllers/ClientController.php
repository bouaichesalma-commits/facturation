<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Agence;  // Adding the Agence model to retrieve the logo
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::withCount(['devis', 'factures'])->orderBy('id', 'desc')->get();

        $this->authorize('viewAny', Client::class);
        
   
        $agence = Agence::first(); // Retrieving the logo from the database
        
        return response()->view('client.index', compact('clients', 'agence'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Client::class);
        
        $agence = Agence::first(); // Retrieving the logo when creating a new client
        
        return response()->view('client.create', compact('agence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $client = new Client();
        $this->authorize('create', Client::class);
        $client->fill($request->all())->save();
        
        return redirect('/client/create')->with('info', 'The client added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404); // As is here, logo retrieval can be added if needed for display
        // $client = Client::findOrFail($id);
        // return response()->view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('update', $client);

        $agence = Agence::first(); // Retrieving the logo when editing the client
        
        return response()->view('client.edit', compact('client', 'agence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('update', $client);

        $client->fill($request->all())->update();
        
        return redirect('/client/' . $id . '/edit')->with('info', 'The client updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('delete', $client);

        $client->delete();
        
        return redirect('/client');
    }
}
