<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\Categorie;
use App\Models\CategorieStagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StagiaireController extends Controller
{
    // Afficher tous les stagiaires
    public function index()
    {
        $stagiaires = Stagiaire::all();
        return view('stagiaires.index', compact('stagiaires'));
    }

    // Afficher le formulaire de création d'un stagiaire
    public function create()
    {
        $categories = CategorieStagiaire::all();
        return view('stagiaires.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'required|integer',  // Validation du champ catégorie
            'email' => 'required|email|unique:stagiaires,email',
            'cv' => 'nullable|file|mimes:pdf,doc,docx',
            'demande_stage' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $cvPath = $request->file('cv') ? $request->file('cv')->store('cvs') : null;
        $demandeStagePath = $request->file('demande_stage') ? $request->file('demande_stage')->store('demandes') : null;

        Stagiaire::create([
            'name' => $request->name,
            'categorie_id' => $request->categorie_id,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'cv_path' => $cvPath,
            'demande_stage_path' => $demandeStagePath,
            'portfolio_link' => $request->portfolio_link,
            'description' => $request->description,
        ]);

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire ajouté avec succès.');
    }
    // Formulaire d'édition d'un stagiaire
    public function edit($id)
    {
        $stagiaire = Stagiaire::findOrFail($id);
        $categories = CategorieStagiaire::all();
        return view('stagiaires.edit', compact('stagiaire', 'categories'));
    }

    // Mise à jour d'un stagiaire
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'required|integer',
            'email' => 'required|email',
            'cv' => 'nullable|file|mimes:pdf,doc,docx',
            'demande_stage' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $stagiaire = Stagiaire::findOrFail($id);

        if ($request->hasFile('cv')) {
            if ($stagiaire->cv_path) {
                Storage::delete($stagiaire->cv_path);
            }
            $cvPath = $request->file('cv')->store('cvs');
        } else {
            $cvPath = $stagiaire->cv_path;
        }

        if ($request->hasFile('demande_stage')) {
            if ($stagiaire->demande_stage_path) {
                Storage::delete($stagiaire->demande_stage_path);
            }
            $demandeStagePath = $request->file('demande_stage')->store('demandes');
        } else {
            $demandeStagePath = $stagiaire->demande_stage_path;
        }

        $stagiaire->update([
            'name' => $request->name,
            'categorie_id' => $request->categorie_id,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'cv_path' => $cvPath,
            'demande_stage_path' => $demandeStagePath,
            'portfolio_link' => $request->portfolio_link,
            'description' => $request->description,
        ]);

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire mis à jour avec succès.');
    }

    // Suppression d'un stagiaire
    public function destroy($id)
    {
        $stagiaire = Stagiaire::findOrFail($id);
        
        if ($stagiaire->cv_path) {
            Storage::delete($stagiaire->cv_path);
        }
        if ($stagiaire->demande_stage_path) {
            Storage::delete($stagiaire->demande_stage_path);
        }

        $stagiaire->delete();

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire supprimé avec succès.');
    }
}
