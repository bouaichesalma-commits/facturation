<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastNum = Fournisseur::orderBy('id', 'desc')->value('num');
        $nextNum = 1;
        if ($lastNum && is_numeric($lastNum)) {
            $nextNum = (int)$lastNum + 1;
        } elseif ($lastNum && strpos($lastNum, '/') !== false) {
            // Handle cases where number might have a slash like invoices
            $nextNum = (int)explode('/', $lastNum)[0] + 1;
        }
        
        $nextNumFormatted = (string)$nextNum;
        
        return view('fournisseurs.create', compact('nextNumFormatted'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'ste' => 'nullable|string|max:255',
            'ice' => 'nullable|string|max:255',
            'num' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        return view('fournisseurs.show', compact('fournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'ste' => 'nullable|string|max:255',
            'ice' => 'nullable|string|max:255',
            'num' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
        ]);

        $fournisseur->update($request->all());

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé avec succès.');
    }
}
