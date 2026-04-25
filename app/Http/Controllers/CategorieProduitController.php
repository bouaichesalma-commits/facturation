<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieProduit;
use App\Models\Agence;

class CategorieProduitController extends Controller
{
    /**
     * Display the list of categories.
     */
    public function index()
    {
        $categories = CategorieProduit::all();
        $agence = Agence::first();

        return view('categorieproduits.index', compact('categories', 'agence'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $agence = Agence::first();

        return view('categorieproduits.create', compact('agence'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categorie' => 'required|string|max:50',
        ]);

        CategorieProduit::create($request->all());

        return redirect()->route('categorieproduits.index')->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(CategorieProduit $categorieproduit)
    {
        $agence = Agence::first();

        return view('categorieproduits.edit', compact('categorieproduit', 'agence'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, CategorieProduit $categorieproduit)
    {
        $request->validate([
            'categorie' => 'required|string|max:50',
        ]);

        $categorieproduit->update($request->all());

        return redirect()->route('categorieproduits.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Delete a category.
     */
    public function destroy(CategorieProduit $categorieproduit)
    {
        $categorieproduit->delete();

        return redirect()->route('categorieproduits.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
