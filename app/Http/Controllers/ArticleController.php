<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Models\CategorieProduit;
use App\Models\Agence;  // Adding the Agence model to retrieve the logo

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Articles = Article::latest('created_at')->get();
        $this->authorize('viewAny', Article::class);
        
        $agence = Agence::first(); // Retrieve the logo from the database
        
        return response()->view('Article.index', compact('Articles', 'agence'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategorieProduit::all();  // Fetch all categories

        $this->authorize('create', Article::class);

        $agence = Agence::first(); // Retrieve the logo when creating a new article

        return response()->view('Article.create', compact('categories', 'agence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
            $Article = new Article();
            $this->authorize('create', Article::class);
            $Article->fill($request->all())->save();
            
            return redirect('/article/create')->with('info', 'The Article added successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in ArticleController@store: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'article.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Article = Article::findOrFail($id);
         $categories = CategorieProduit::all();  // Fetch all categories

        $this->authorize('update', $Article);

        $agence = Agence::first(); // Retrieve the logo when editing the article
        
        return response()->view('Article.edit', compact('Article', 'agence' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, string $id)
    {
        try {
            $Article = Article::findOrFail($id);
            $this->authorize('update', $Article);

            $Article->fill($request->all())->update();
            
            return redirect('/article/'.$id.'/edit')->with('info', 'The Article updated successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in ArticleController@update: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'article.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $Article = Article::findOrFail($id);
            $this->authorize('delete', $Article);
            $Article->delete();
            
            return redirect('/article');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in ArticleController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression de l\'article.');
        }
    }
}
