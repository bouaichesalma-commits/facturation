<?php

namespace App\Http\Controllers;
use App\Models\CategorieEquipe;
use App\Models\Equipe;
use Illuminate\Support\Facades\Storage;



use Illuminate\Http\Request;

class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipes = Equipe::all();
        return view('equipe.index', compact('equipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategorieEquipe::all();
        return view('equipe.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
     public function store(Request $request)
     {
         $request->validate([
             // Validation rules for other fields
             'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
             'demande_stage' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
             // Other fields validation
         ]);
     
         $equipe = new Equipe([
             'name' => $request->name,
             'categorieequipe_id' => $request->categorieequipe_id,
             'telephone' => $request->telephone,
             'email' => $request->email,
             'adresse' => $request->adresse,
             'portfolio_link' => $request->portfolio_link,
             'description' => $request->description,
         ]);
     
         if ($request->hasFile('cv')) {
             $equipe->cv_path = $request->file('cv')->store('cvs', 'public');
         }
     
         if ($request->hasFile('demande_stage')) {
             $equipe->demande_stage_path = $request->file('demande_stage')->store('demandes_stages', 'public');
         }
     
         $equipe->save();
     
         return redirect()->route('equipe.index')->with('success', 'Equipe créée avec succès.');
     }

     public function showCv($id)
    {
        // Fetch Equipe from database
        $equipe = Equipe::findOrFail($id);

        // Build the full file path
        $filePath = storage_path('app/public/' . $equipe->cv_path);

        // Check if the file exists
        if (!Storage::exists('public/' . $equipe->cv_path)) {
            abort(404);
        }

        // Return the file as response
        return response()->file($filePath);
    }
    public function showdemandestage($id)
    {
        // Fetch Equipe from database
        $equipe = Equipe::findOrFail($id);

        // Build the full file path
        $filePath = storage_path('app/public/' . $equipe->demande_stage_path);

        // Check if the file exists
        if (!Storage::exists('public/' . $equipe->demande_stage_path)) {
            abort(404);
        }

        // Return the file as response
        return response()->file($filePath);
    }


    public function show($id)
    {
        $equipe = Equipe::findOrFail($id);
        return view('equipe.show', compact('equipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $equipe = Equipe::findOrFail($id);
        $categories = CategorieEquipe::all();
        return view('equipe.edit', compact('equipe', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'categorieequipe_id' => 'required|exists:categorie_equipes,id',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:100',
            'adresse' => 'nullable|string|max:200',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'demande_stage' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'portfolio_link' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $equipe = Equipe::findOrFail($id);
        $equipe->fill($request->all());

        if ($request->hasFile('cv')) {
            Storage::disk('public')->delete($equipe->cv_path);
            $equipe->cv_path = $request->file('cv')->store('cvs', 'public');
        }

        if ($request->hasFile('demande_stage')) {
            Storage::disk('public')->delete($equipe->demande_stage_path);
            $equipe->demande_stage_path = $request->file('demande_stage')->store('demandes_stages', 'public');
        }

        $equipe->save();

        return redirect()->route('equipe.index')->with('success', 'Equipe updated successfully.');
    }

    public function destroy($id)
    {
        $equipe = Equipe::findOrFail($id);

        // Check if cv_path exists and is not null before deleting
        if ($equipe->cv_path) {
            Storage::disk('public')->delete($equipe->cv_path);
        }

        // Check if demande_stage_path exists and is not null before deleting
        if ($equipe->demande_stage_path) {
            Storage::disk('public')->delete($equipe->demande_stage_path);
        }

        // Now delete the equipe record
        $equipe->delete();

        return redirect()->route('equipe.index')->with('success', 'Equipe deleted successfully.');
    }

}
