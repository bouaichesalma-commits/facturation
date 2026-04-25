<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Client;
use App\Models\Equipe;
use App\Models\CategorieProjects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('client', 'equipe', 'categorieproject')->get();
        return view('projects.index', compact('projects'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $equipes = Equipe::all();
        $categories = CategorieProjects::all();
        return view('projects.create', compact('clients', 'equipes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'client_id' => 'required|exists:clients,id',
            'equipe_id' => 'required|exists:equipes,id',
            'categorieproject_id' => 'required|exists:categorie_projects,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $clients = Client::all();
        $equipes = Equipe::all();
        $categories = CategorieProjects::all();
        return view('projects.edit', compact('project', 'clients', 'equipes', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'client_id' => 'required|exists:clients,id',
            'equipe_id' => 'required|exists:equipes,id',
            'categorieproject_id' => 'required|exists:categorie_projects,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
