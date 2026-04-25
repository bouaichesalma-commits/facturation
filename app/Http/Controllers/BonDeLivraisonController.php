<?php

namespace App\Http\Controllers;

use App\Models\BonDeLivraison;
use App\Models\Agence;
use App\Models\Client;
use App\Models\Article;
use App\Http\Requests\BonDeLivraisonRequest;
use Illuminate\Http\Request;
use App\Models\CategorieProduit;
use App\Models\Fournisseur ;
use App\Models\Marque;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BonDeLivraisonController extends Controller
{
    public function index()
    {
        $bons = BonDeLivraison::orderBy('date', 'desc')->orderBy('id', 'asc')->get();
        $latestBon = $bons->first();
        $agence = Agence::first();

        return view('bon.index', compact('bons', 'latestBon', 'agence'));
    }

    public function create()
    {
        $clients = Client::all();
        $articles = Article::all();
        $agence = Agence::first();

         $fournisseurs = Fournisseur::all();
        $marques = Marque::all();
        $categories = CategorieProduit::all();
        return view('bon.create', compact('clients', 'articles', 'agence','categories','fournisseurs','marques'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client' => 'required',
            'date' => 'required|date',
            'num' => 'required',
            'articles' => 'required',
        ]);

        $articles = json_decode($request->articles, true);
        if (!$articles || !is_array($articles)) {
            return back()->withInput()->withErrors(['articles' => 'Veuillez ajouter au moins un produit valide.']);
        }

        foreach ($articles as $index => $articleData) {
            if (empty(trim($articleData['produit']))) {
                return back()->withInput()->withErrors(['articles' => "Le nom du produit à la ligne " . ($index + 1) . " est obligatoire."]);
            }
            if (strlen(trim($articleData['produit'])) > 255) {
                return back()->withInput()->withErrors(['articles' => "Le nom du produit à la ligne " . ($index + 1) . " ne peut pas dépasser 255 caractères."]);
            }
        }

         $request->validate([
        'client' => 'required|exists:clients,id',
        'num' => [
            'required',
            'string',
            \Illuminate\Validation\Rule::unique('bon_de_livraisons')->where(function ($query) use ($request) {
                return $query->whereYear('date', date('Y', strtotime($request->date)));
            })
        ],
        'date' => 'required|date',
        'articles' => 'required|json', 
            'montant' => 'required|numeric',
            'montantRemise' => 'nullable|numeric|min:0', // Corrected typo
            'valeurTVA' => 'nullable|numeric',
            'totalTTC' => 'required|numeric',
        ]);

    DB::beginTransaction();

    try {
        // Handle bon num formatting
        $enteredNum = $request->num;
        if (strpos($enteredNum, '/') === false) {
            $currentYear = date('Y', strtotime($request->date));
            $formattedNum = sprintf('%05d/%s', (int)$enteredNum, $currentYear);
        } else {
            $parts = explode('/', $enteredNum);
            $numericPart = (int)$parts[0];
            $yearPart = $parts[1];
            if (strlen($yearPart) == 2) {
                $yearPart = '20' . $yearPart;
            }
            $formattedNum = sprintf('%05d/%s', $numericPart, $yearPart);
        }

        $bon = BonDeLivraison::create([
            'client_id' => $request->client,
            'num' => $formattedNum,
            'date' => $request->date,
            'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
            'taux' => $request->taux ?? 0,  
            'montant' => $request->montant,  // double
            'type' =>'0',  // tinyint
            'remise' => $request->remise,  // int
            'etatremise' => $request->etatremise ,  // varchar(255)
        ]);

        
        $articles = json_decode($request->articles, true);

        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {


                //  if ($existingArticle->Quantite < $articleData['quantite']) {
                //     DB::rollBack();
                //     return back()->withErrors([
                //         'stock' => "La quantité demandée pour '{$produitName}' dépasse le stock disponible."
                //     ]);
                // }
                DB::table('bon_article')->insert([
                    'bon_de_livraison_id' => $bon->id,
                    'article_id' => $existingArticle->id,
                    'quantite' => $articleData['quantite'],
                    'prix_article' => $articleData['prix'],
                    // 'total' => $articleData['quantite'] * $articleData['prix'],
                ]);
                
                //  $existingArticle->decrement('Quantite', $articleData['quantite']);

            } else {
                DB::table('custom_bon_articles')->insert([
                    'bon_id' => $bon->id,
                    'name' => $produitName,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                    // 'total' => $articleData['quantite'] * $articleData['prix'],
                ]);
            }
        }

        DB::commit();
        return redirect()->route('bon.index')->with('info', 'bon delivraison créé avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error("Error in BonDeLivraisonController@store: " . $e->getMessage());
        return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement du bon de livraison. Veuillez réessayer.');
    }
}

    

    public function edit($id)
    {
        $bon = BonDeLivraison::findOrFail($id);
        $clients = Client::all();
        $articles = Article::all();

         $fournisseurs = Fournisseur::all();
        $marques = Marque::all();
        $categories = CategorieProduit::all();
      
    
    // Get standard articles
    $standardArticles = DB::table('bon_article')
        ->where('bon_de_livraison_id', $bon->id)
        ->join('articles', 'bon_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'bon_article.quantite as quantite', 'bon_article.prix_article as prix')
        ->get()
        ->toArray();
    
    // Get custom articles
    $customArticles = DB::table('custom_bon_articles')
        ->where('bon_id', $bon->id)
        ->select('name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();
    
    // Combine both types of articles
    $bonArticles = array_merge($standardArticles, $customArticles);

        return view('bon.edit', compact('bon',  'clients' ,'articles', 'bonArticles' , 'categories','fournisseurs','marques'));
    }
    public function update(Request $request, BonDeLivraison $bon)
    {
        $request->validate([
            'client' => 'required',
            'date' => 'required|date',
            'num' => 'required',
            'articles' => 'required',
        ]);

        $articles = json_decode($request->articles, true);
        if (!$articles || !is_array($articles)) {
            return back()->withInput()->withErrors(['articles' => 'Veuillez ajouter au moins un produit valide.']);
        }

        foreach ($articles as $index => $articleData) {
            if (empty(trim($articleData['produit']))) {
                return back()->withInput()->withErrors(['articles' => "Le nom du produit à la ligne " . ($index + 1) . " est obligatoire."]);
            }
            if (strlen(trim($articleData['produit'])) > 255) {
                return back()->withInput()->withErrors(['articles' => "Le nom du produit à la ligne " . ($index + 1) . " ne peut pas dépasser 255 caractères."]);
            }
        }

        $request->validate([
            'client' => 'required|exists:clients,id',
            'num' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('bon_de_livraisons', 'num')->where(function ($query) use ($request) {
                    return $query->whereYear('date', date('Y', strtotime($request->date)));
                })->ignore($bon->id)
            ],
            'date' => 'required|date',
            'articles' => 'required|json',
            'montant' => 'required|numeric',
            'montantRemise' => 'nullable|numeric|min:0',
            'valeurTVA' => 'nullable|numeric',
            'totalTTC' => 'required|numeric',
        ]);

    DB::beginTransaction();

    try {
       // Handle bon num formatting
        $enteredNum = $request->num;
        if (strpos($enteredNum, '/') === false) {
            $currentYear = date('Y', strtotime($request->date));
            $formattedNum = sprintf('%05d/%s', (int)$enteredNum, $currentYear);
        } else {
            $parts = explode('/', $enteredNum);
            $numericPart = (int)$parts[0];
            $yearPart = $parts[1];
            if (strlen($yearPart) == 2) {
                $yearPart = '20' . $yearPart;
            }
            $formattedNum = sprintf('%05d/%s', $numericPart, $yearPart);
        }

        // Update the bons
        $bon->update([
            'client_id' => $request->client,
            'num' => $formattedNum,
            'date' => $request->date,
            'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
            'taux' => $request->taux ?? 0,
            'montant' => $request->montant,
            'remise' => $request->remise,
            'etatremise' => $request->etatremise,
        ]);

        
        // Delete existing articles
        DB::table('bon_article')->where('bon_de_livraison_id', $bon->id)->delete();
        DB::table('custom_bon_articles')->where('bon_id', $bon->id)->delete();

        // Add new articles
        $articles = json_decode($request->articles, true);
        

        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {
                DB::table('bon_article')->insert([
                    'bon_de_livraison_id' => $bon->id,
                    'article_id' => $existingArticle->id,
                    'quantite' => $articleData['quantite'],
                      'prix_article' => $articleData['prix'],
                ]);
            } else {
                DB::table('custom_bon_articles')->insert([
                    'bon_id' => $bon->id,
                    'name' => $produitName,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }
        }
        
        DB::commit();
        return redirect()->route('bon.index')->with('info', 'bon de livraison mis à jour avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error("Error in BonDeLivraisonController@update: " . $e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour du bon de livraison.');
    }
}
public function show(string $id)
{
    $bon = BonDeLivraison::with('client')->findOrFail($id);
    $agences = Agence::first();

    $standardArticles = DB::table('bon_article')
        ->where('bon_de_livraison_id', $id)
        ->join('articles', 'bon_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'bon_article.quantite as quantite', 'bon_article.prix_article as prix')
        ->get()
        ->toArray();

    $customArticles = DB::table('custom_bon_articles')
        ->where('bon_id', $id)
        ->select('name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();

    $bonArticles = array_merge($standardArticles, $customArticles);

    return view('bon.show', compact('agences', 'bonArticles', 'bon'));
}


    public function destroy($id)
    {
        try {
            $bon = BonDeLivraison::findOrFail($id);
            $bon->delete();
            return redirect()->route('bon.index')->with('success', 'Bon de livraison supprimé avec succès.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in BonDeLivraisonController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression du bon de livraison.');
        }
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getBonData($id);
        
        $html = view('bon.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Bon de Livraison " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download($id)
    {
        $data = $this->getBonData($id);
        return view('bon.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getBonData($id)
    {
        $bon = BonDeLivraison::findOrFail($id);
        $agence = Agence::first();

        // Handle bon num formatting
        $enteredNum = strval($bon->num);
        if (strpos($enteredNum, '/') === false) {
            $currentYear = date('Y', strtotime($bon->date));
            $numero = sprintf('%05d/%s', (int)$enteredNum, $currentYear);
        } else {
            $parts = explode('/', $enteredNum);
            $numericPart = (int)$parts[0];
            $yearPart = $parts[1];
            if (strlen($yearPart) == 2) {
                $yearPart = '20' . $yearPart;
            }
            $numero = sprintf('%05d/%s', $numericPart, $yearPart);
        }

        $client = $bon->client->nom;
        $ice = $bon->client->ice;
        $tel = $bon->client->tel;
        $adresse = $bon->client->adresse;
        $email = $bon->client->email;
        $date = date_format(date_create($bon->date), 'd / m / Y');

        $standardArticles = DB::table('bon_article')
            ->where('bon_de_livraison_id', $id)
            ->join('articles', 'bon_article.article_id', '=', 'articles.id')
            ->select('articles.id', 'articles.designation as produit', 'bon_article.quantite as quantite', 'bon_article.prix_article as prix')
            ->get()
            ->toArray();

        $customArticles = DB::table('custom_bon_articles')
            ->where('bon_id', $id)
            ->select('name as produit', 'quantity as quantite', 'prix')
            ->get()
            ->toArray();

        $bonArticles = array_merge($standardArticles, $customArticles);

        $total_ht = (float)$bon->montant;
        $tva = $bon->tva;
        $taux = $bon->taux;
        
        $total_Remise = 0;
        $Remise = $bon->remise;
        $Etat_remise = $bon->etatremise;

        if ($Etat_remise == "pourcentage") {
            $total_Remise = $total_ht * ($Remise / 100);
        } else if($Etat_remise == "montant"){
            $total_Remise = $Remise;
        }
        
        $tot = $total_ht - $total_Remise;
        $total_tva = $tva ? ($tot * (20 / 100)) : 0;
        $total_ht_avec_remise = $total_ht - $total_Remise;

        $total_ttc = $total_ht - $total_Remise + $total_tva; 
        $total_words = strtoupper(NumberToWords::transformCurrency('fr', (int) round($total_ttc * 100), 'MAD'));

        return compact(
            'agence', 'numero', 'client', 'ice', 'tel', 'adresse', 'email', 'date',
            'bonArticles', 'total_ht', 'tva', 'taux', 'total_tva', 'total_ttc', 'total_words',
            "total_Remise", "Remise", "total_ht_avec_remise", "Etat_remise", "bon"
        );
    }
}
