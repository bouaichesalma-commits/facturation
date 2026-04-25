<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class DetailsStockController extends Controller
{
    /**
     * Afficher la liste des produits.
     */
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));

        $articles = Article::whereYear('created_at', $year)->get();

        return view('stock.index', compact('articles', 'year'));
    }

    


}
