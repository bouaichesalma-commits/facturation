<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marques = Marque::all();
        return view('marques.index', compact('marques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Marque::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('marques.index')->with('success', 'Marque ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $marque = Marque::findOrFail($id);
        return view('marques.show', compact('marque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $marque = Marque::findOrFail($id);
        return view('marques.edit', compact('marque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $marque = Marque::findOrFail($id);
        $marque->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('marques.index')->with('success', 'Marque mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marque = Marque::findOrFail($id);
        $marque->delete();

        return redirect()->route('marques.index')->with('success', 'Marque supprimée avec succès.');
    }
}
