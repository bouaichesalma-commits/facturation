<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorieProjects;
use App\Models\Agence; // Adding the Agence model to retrieve the logo

class CategorieProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategorieProjects::all();
        $agence = Agence::first(); // Retrieve the agence logo from the database

        return view('categorieprojects.index', compact('categories', 'agence'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agence = Agence::first(); // Retrieve the agence logo from the database
        return view('categorieprojects.create', compact('agence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        CategorieProjects::create($request->all());

        return redirect()->route('categorieprojects.index')->with('success', 'Category created successfully.');
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
    public function edit(CategorieProjects $categorieproject)
    {
        $agence = Agence::first(); // Retrieve the agence logo from the database
        return view('categorieprojects.edit', compact('categorieproject', 'agence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategorieProjects $categorieproject)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $categorieproject->update($request->all());

        return redirect()->route('categorieprojects.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategorieProjects $categorieproject)
    {
        $categorieproject->delete();
        return redirect()->route('categorieprojects.index')->with('success', 'Category deleted successfully.');
    }
}
