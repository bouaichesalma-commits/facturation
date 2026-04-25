<?php
namespace App\Http\Controllers;

use App\Models\CategorieAttestation;
use App\Models\Agence;// Add Agence model
use Illuminate\Http\Request;

class CategorieAttestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorieAttestations = CategorieAttestation::all();
        $agence = Agence::first(); // Retrieve the first Agence (you can adjust based on your needs)
        return view('categorie_attestations.index', compact('categorieAttestations', 'agence'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agence = Agence::first(); // Retrieve the first Agence (you can adjust based on your needs)
        return view('categorie_attestations.create', compact('agence'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        CategorieAttestation::create($request->all());

        return redirect()->route('categorie_attestations.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategorieAttestation $categorieAttestation)
    {
        $agence = Agence::first(); // Retrieve the first Agence (you can adjust based on your needs)
        return view('categorie_attestations.show', compact('categorieAttestation', 'agence'));
    }

    public function edit(CategorieAttestation $categorieAttestation)
    {
        $agence = Agence::first(); // Retrieve the first Agence (you can adjust based on your needs)
        return view('categorie_attestations.edit', compact('categorieAttestation', 'agence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategorieAttestation $categorieAttestation)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $categorieAttestation->update($request->all());

        return redirect()->route('categorie_attestations.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(CategorieAttestation $categorieAttestation)
    {
        $categorieAttestation->delete();
        return redirect()->route('categorie_attestations.index')->with('success', 'Category deleted successfully.');
    }
}
