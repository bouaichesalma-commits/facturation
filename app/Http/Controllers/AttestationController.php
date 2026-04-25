<?php

namespace App\Http\Controllers;

use App\Models\Attestation;
use App\Models\CategorieEquipe;
use App\Models\Equipe;
use App\Models\Stagiaire;
use App\Models\CategorieProjects;
use App\Models\CategorieAttestation;
use App\Models\Agence; // Adding the Agence model

use Illuminate\Http\Request;

class AttestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attestations = Attestation::with(['equipe', 'categorieproject', 'categorieAttestation'])->get();
        $agence = Agence::first(); // Fetch the first record from the Agence table (logo)
        return view('attestations.index', compact('attestations', 'agence'));
    }

    public function create()
    {
        $equipes = Equipe::all();
        $Stagiaires = Stagiaire::all();
        $categorieProjects = CategorieProjects::all();
        $categorieAttestations = CategorieAttestation::all();
        $agence = Agence::first(); // Fetch the logo
        return view('attestations.create', compact('equipes', 'categorieProjects' ,'Stagiaires', 'categorieAttestations', 'agence'));
    }

    public function store(Request $request)
{
    $request->validate([
        'categorie_attestation_id' => 'required|exists:categorie_attestations,id',
        'categorieproject_id' => 'required|exists:categorie_projects,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'signature_date' => 'required|date|after_or_equal:end_date',
        'equipe_id' => 'nullable|exists:equipes,id',
        'stagiaire_id' => 'nullable|exists:stagiaires,id',
    ]);

    // **Ensure that at least one of the fields is provided**
    if (!$request->filled('equipe_id') && !$request->filled('stagiaire_id')) {
        return redirect()->back()->withErrors(['general' => 'You must select a team or an intern.']);
    }

    // **Insert the values into the database**
    Attestation::create([
        'categorie_attestation_id' => $request->categorie_attestation_id,
        'categorieproject_id' => $request->categorieproject_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'signature_date' => $request->signature_date,
        'equipe_id' => $request->equipe_id,
        'stagiaire_id' => $request->stagiaire_id,
    ]);

    return redirect()->route('attestations.index')->with('success', 'Attestation created successfully.');
}

public function edit(Attestation $attestation)
{
    $equipes = Equipe::all();
    $Stagiaires= Stagiaire::all();  // Ensure this matches the name used in compact()
    $categorieProjects = CategorieProjects::all();
    $categorieAttestations = CategorieAttestation::all();
    $agence = Agence::first(); // Fetch the logo

    return view('attestations.edit', compact('attestation', 'equipes', 'categorieProjects', 'categorieAttestations', 'agence', 'Stagiaires'));
}

    public function update(Request $request, Attestation $attestation)
{
    $request->validate([
        'categorie_attestation_id' => 'required|exists:categorie_attestations,id',
        'categorieproject_id' => 'required|exists:categorie_projects,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'signature_date' => 'required|date|after_or_equal:end_date',
        'equipe_id' => 'nullable|exists:equipes,id',
        'stagiaire_id' => 'nullable|exists:stagiaires,id',
    ]);

    // **Ensure that at least one of the fields is provided**
    if (!$request->filled('equipe_id') && !$request->filled('stagiaire_id')) {
        return redirect()->back()->withErrors(['general' => 'You must select a team or an intern.']);
    }

    // **Update the values in the database**
    $attestation->update([
        'categorie_attestation_id' => $request->categorie_attestation_id,
        'categorieproject_id' => $request->categorieproject_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'signature_date' => $request->signature_date,
        'equipe_id' => $request->equipe_id,
        'stagiaire_id' => $request->stagiaire_id,
    ]);

    return redirect()->route('attestations.index')->with('success', 'Attestation updated successfully.');
}

    public function destroy(Attestation $attestation)
    {
        $attestation->delete();
        return redirect()->route('attestations.index')->with('success', 'Attestation deleted successfully.');
    }

    public function download(string $id)
{
    $attestation = Attestation::findOrFail($id);
    
    // Retrieve category name and other related data
    $categorieAttestations = $attestation->categorieAttestation->name;
    $start_date = date_format(date_create($attestation->start_date), 'd / m / Y');
    $end_date = date_format(date_create($attestation->end_date), 'd / m / Y');
    $signature_date = date_format(date_create($attestation->signature_date), 'd / m / Y');
    $agence = Agence::first(); // Fetch the logo
    
    // Check if agence record exists and has logo
    if (!$agence || !$agence->logo) {
        // Provide a fallback logo if not available
        $agence->logo = 'default-logo.png'; // Fallback logo path
    }

    // Additional variables based on category selection
    $equipe = null;
    $stagiaire = null;
    
    // Check the category type and set appropriate data
    if ($categorieAttestations === 'Attestation de travail') {
        $equipe = $attestation->equipe->name;
    } elseif ($categorieAttestations === 'Attestation de stage') {
        $stagiaire = $attestation->stagiaire->name;
    }

    return response()->view('attestations.download', compact(
        'categorieAttestations',
        'equipe',
        'stagiaire',
        'start_date',
        'end_date',
        'signature_date',
        'agence' // Pass the logo to the view
    ));
}
}