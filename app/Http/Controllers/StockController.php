<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StockRequest;
use App\Models\CategorieProduit;
use App\Models\Agence;

class StockController extends Controller
{
    /**
     * Affiche la liste des stocks.
     */
    public function index()
    {
        $Stocks = Stock::latest('created_at')->get();
        $this->authorize('viewAny', Stock::class);

        $agence = Agence::first();

        return response()->view('stock.index', compact('Stocks', 'agence'));
    }

    /**
     * Affiche le formulaire de création d’un nouveau stock.
     */
    public function create()
    {
        $categories = CategorieProduit::all();
        $this->authorize('create', Stock::class);

        $agence = Agence::first();

        return response()->view('stock.create', compact('categories', 'agence'));
    }

    /**
     * Enregistre un nouveau stock en base de données.
     */
    public function store(StockRequest $request)
    {
        $Stock = new Stock();
        $this->authorize('create', Stock::class);
        
        $Stock->fill($request->all())->save();

        return redirect('/stock/create')->with('info', 'Le stock a été ajouté avec succès !');
    }

    /**
     * Affiche une ressource spécifique (désactivé ici).
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Affiche le formulaire d’édition d’un stock.
     */
    public function edit(string $id)
    {
        $Stock = Stock::findOrFail($id);
        $this->authorize('update', $Stock);
         $categories = CategorieProduit::all();

        $agence = Agence::first();

        return response()->view('stock.edit', compact('Stock', 'agence' ,'categories'));
    }

    /**
     * Met à jour un stock existant.
     */
    public function update(StockRequest $request, string $id)
    {
        $Stock = Stock::findOrFail($id);
        $this->authorize('update', $Stock);

        $Stock->fill($request->all())->update();

        return redirect('/stock/' . $id . '/edit')->with('info', 'Le stock a été modifié avec succès !');
    }

    /**
     * Supprime un stock.
     */
    public function destroy(string $id)
    {
        $Stock = Stock::findOrFail($id);
        $this->authorize('delete', $Stock);
        $Stock->delete();

        return redirect('/stock')->with('info', 'Le stock a été supprimé avec succès !');
    }
}
