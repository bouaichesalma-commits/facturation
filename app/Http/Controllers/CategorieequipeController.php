<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieEquipe;
use App\Models\Agence; // Adding the Agence model to retrieve the logo

class CategorieequipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategorieEquipe::all();
        $agence = Agence::first(); // Retrieve the logo or agency details

        return view('categorieequipe.index', compact('categories', 'agence'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agence = Agence::first(); // Retrieve the logo or agency details

        return view('categorieequipe.create', compact('agence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        CategorieEquipe::create($request->all());

        return redirect()->route('categorieequipe.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategorieEquipe $categorieequipe)
    {
        $agence = Agence::first(); // Retrieve the logo or agency details

        return view('categorieequipe.edit', compact('categorieequipe', 'agence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategorieEquipe $categorieequipe)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $categorieequipe->update($request->all());

        return redirect()->route('categorieequipe.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategorieEquipe $categorieequipe)
    {
        $categorieequipe->delete();

        return redirect()->route('categorieequipe.index')->with('success', 'Category deleted successfully.');
    }
}
