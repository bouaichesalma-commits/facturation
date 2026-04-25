<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeStage;
use App\Models\Agence;  // Adding the Agence model to retrieve the logo

class DemandeStageController extends Controller
{
    /**
     * Display the list of stage requests.
     */
    public function index()
    {
        $demandes = DemandeStage::all(); 
        $agence = Agence::first(); // Retrieve the logo from the database

        return view('demande_stage.index', compact('demandes', 'agence')); 
    }

    /**
     * Show the form for creating a new stage request.
     */
    public function create()
    {
        $agence = Agence::first(); // Retrieve the logo from the database
        return view('demande_stage.create', compact('agence'));
    }

    /**
     * Store a newly created stage request in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'lettre_motivation' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'message']);

        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('cv', 'public');
        }

        if ($request->hasFile('lettre_motivation')) {
            $data['lettre_motivation'] = $request->file('lettre_motivation')->store('uploads/lettres', 'public');
        }

        DemandeStage::create($data);

        return redirect()->route('demande.index')->with('success', 'Demande envoyée avec succès.');
    }

    /**
     * Show the form for editing a stage request.
     */
    public function edit($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $agence = Agence::first(); // Retrieve the logo from the database
        return view('demande_stage.edit', compact('demande', 'agence'));
    }

    /**
     * Update the specified stage request in the database.
     */
    public function update(Request $request, $id)
    {
        $demande = DemandeStage::findOrFail($id);
        
        $request->validate([
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'lettre_motivation' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
        
        $data = $request->only(['name', 'email', 'message']);

        if ($request->hasFile('cv')) {
            if ($demande->cv) {
                Storage::disk('public')->delete($demande->cv);
            }
            $data['cv'] = $request->file('cv')->store('cv', 'public');
        }

        if ($request->hasFile('lettre_motivation')) {
            if ($demande->lettre_motivation) {
                Storage::disk('public')->delete($demande->lettre_motivation);
            }
            $data['lettre_motivation'] = $request->file('lettre_motivation')->store('uploads/lettres', 'public');
        }

        $demande->update($data);

        return redirect()->route('demande.index')->with('success', 'Demande mise à jour avec succès.');
    }

    /**
     * Display the specified stage request.
     */
    public function show($id)
    {
        $demande = DemandeStage::findOrFail($id);
        $agence = Agence::first(); // Retrieve the logo from the database
        return view('demande_stage.show', compact('demande', 'agence'));
    }

    /**
     * Delete the specified stage request.
     */
    public function destroy($id)
    {
        $demande = DemandeStage::findOrFail($id);

        if ($demande->cv) {
            Storage::disk('public')->delete($demande->cv);
        }

        if ($demande->lettre_motivation) {
            Storage::disk('public')->delete($demande->lettre_motivation);
        }

        $demande->delete();

        return redirect()->route('demande.index')->with('success', 'Demande supprimée avec succès.');
    }

    /**
     * Download the CV or Lettre de Motivation for a stage request.
     */
    public function download($id)
    {
        $demande = DemandeStage::findOrFail($id);

        $cv = storage_path('app/public/cv/' . $demande->cv);
        $lettre_motivation = storage_path('app/public/uploads/lettres/' . $demande->lettre_motivation);

        if (file_exists($cv)) {
            return response()->download($cv);
        } elseif (file_exists($lettre_motivation)) {
            return response()->download($lettre_motivation);
        } else {
            return redirect()->route('demande.index')->with('error', 'Fichier non trouvé.');
        }
    }

    /**
     * Show the page to download CV or Lettre de Motivation.
     */
    public function Downloadpage($id)
    {
        $demande = DemandeStage::findOrFail($id);
        return view('demande_stage.download', compact('demande'));
    }
}
