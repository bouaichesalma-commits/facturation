<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieStagiaire;
use App\Models\Agence; // Adding the Agence model

class CategorieStagiaireController extends Controller
{
    /**
     * Display the list of categories.
     */
    public function index()
    {
        $categories = CategorieStagiaire::all();
        $agence = Agence::first(); // Retrieve the agence logo from the database

        return view('categorie_stagiaires.index', compact('categories', 'agence'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categorie_stagiaires.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ], [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.max' => 'Le nom de la catégorie ne peut pas dépasser 255 caractères.',
        ]);
        
        CategorieStagiaire::create($request->only(['nom', 'description']));
        return redirect()->route('categorie_stagiaires.index')->with('success', 'Catégorie ajoutée avec succès.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $categorie = CategorieStagiaire::findOrFail($id);
        $agence = Agence::first(); // Retrieve the agence logo from the database
        return view('categorie_stagiaires.edit', compact('categorie', 'agence'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $categorie = CategorieStagiaire::findOrFail($id);
        $categorie->update($request->only(['nom', 'description']));
        return redirect()->route('categorie_stagiaires.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        $categorie = CategorieStagiaire::findOrFail($id);
        $categorie->delete();
        return redirect()->route('categorie_stagiaires.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
