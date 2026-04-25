<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Agence;
use App\Models\Client;
use App\Models\Article;
use App\Http\Requests\avoirRequest;
use App\Models\Avoir;
use App\Models\CategorieProduit;
use App\Models\Fournisseur ;
use App\Models\Marque;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AvoirController extends Controller
{
    public function index()
    {
        $bons = avoir::orderBy('date', 'desc')->orderBy('id', 'asc')->get();
        $latestBon = $bons->first();
        $agence = Agence::first();

        return view('avoir.index', compact('bons', 'latestBon', 'agence'));
    }

    public function create()
    {
        $clients = Client::all();
        $articles = Article::all();
        $agence = Agence::first();

         $fournisseurs = Fournisseur::all();
        $marques = Marque::all();
        $categories = CategorieProduit::all();
        return view('avoir.create', compact('clients', 'articles', 'agence','categories','fournisseurs','marques'));
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
            'num' => 'required|string',
            'date' => 'required|date',
            'articles' => 'required|json',
            'montant' => 'required|numeric',
            'remise' => 'nullable|numeric|min:0',
            'valeurTVA' => 'nullable|numeric',
            'totalTTC' => 'required|numeric',
        ]);

        DB::beginTransaction();

    try {
        // Handle avoir num formatting
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

        $bon = Avoir::create([
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
                DB::table('avoir_article')->insert([
                    'avoir_id' => $bon->id,
                    'article_id' => $existingArticle->id,
                    'quantite' => $articleData['quantite'],
                    'prix_article' => $articleData['prix'],
                    // 'total' => $articleData['quantite'] * $articleData['prix'],
                ]);
                
                //  $existingArticle->decrement('Quantite', $articleData['quantite']);

            } else {
                DB::table('avoir_custom_articles')->insert([
                    'avoir_id' => $bon->id,
                    'name' => $produitName,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                    // 'total' => $articleData['quantite'] * $articleData['prix'],
                ]);
            }
        }

        DB::commit();
        return redirect()->route('avoir.index')->with('info', 'Avoir créé avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
}

    public function edit($id)
    {
        $bon = avoir::findOrFail($id);
        $clients = Client::all();
        $articles = Article::all();

         $fournisseurs = Fournisseur::all();
        $marques = Marque::all();
        $categories = CategorieProduit::all();
        
    // Get standard articles
    $standardArticles = DB::table('avoir_article')
        ->where('avoir_id', $bon->id)
        ->join('articles', 'avoir_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'avoir_article.quantite as quantite', 'avoir_article.prix_article as prix')
        ->get()
        ->toArray();
    
    // Get custom articles
    $customArticles = DB::table('avoir_custom_articles')
        ->where('avoir_id', $bon->id)
        ->select('name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();
    
    // Combine both types of articles
    $bonArticles = array_merge($standardArticles, $customArticles);
  

        return view('avoir.edit', compact('bon',  'clients' ,'articles', 'bonArticles' , 'categories','fournisseurs','marques'));
    }

    public function update(Request $request, Avoir $bon)
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
                \Illuminate\Validation\Rule::unique('avoir', 'num')->where(function ($query) use ($request) {
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
      
        // Handle avoir num formatting
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
        DB::table('avoir_article')->where('avoir_id', $bon->id)->delete();
        DB::table('avoir_custom_articles')->where('avoir_id', $bon->id)->delete();

        // Add new articles
        $articles = json_decode($request->articles, true);
        

        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {
                DB::table('avoir_article')->insert([
                    'avoir_id' => $bon->id,
                    'article_id' => $existingArticle->id,
                    'quantite' => $articleData['quantite'],
                      'prix_article' => $articleData['prix'],
                ]);
            } else {
                DB::table('avoir_custom_articles')->insert([
                    'avoir_id' => $bon->id,
                    'name' => $produitName,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }
        }
           
        
        DB::commit();
        return redirect()->route('avoir.index')->with('info', 'Avoir mis à jour avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error("Error in AvoirController@update: " . $e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'avoir.');
    }
}
public function show(string $id)
{
    $bon = avoir::with('client')->findOrFail($id);
    $agences = Agence::first();

    $standardArticles = DB::table('avoir_article')
        ->where('avoir_id', $id)
        ->join('articles', 'avoir_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'avoir_article.quantite as quantite', 'avoir_article.prix_article as prix')
        ->get()
        ->toArray();

    $customArticles = DB::table('avoir_custom_articles')
        ->where('avoir_id', $id)
        ->select('name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();

    $bonArticles = array_merge($standardArticles, $customArticles);

    return view('avoir.show', compact('agences', 'bonArticles', 'bon'));
}


    public function destroy($id)
    {
        try {
            $bon = avoir::findOrFail($id);
            $bon->delete();
            return redirect()->route('avoir.index')->with('success', 'Avoir supprimé avec succès.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in AvoirController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression de l\'avoir.');
        }
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getBonData($id);
        
        $html = view('avoir.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Avoir " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download($id)
    {
        $data = $this->getBonData($id);
        return view('avoir.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getBonData($id)
    {
        $bon = avoir::findOrFail($id);
        $agence = Agence::first();

        // Handle avoir num formatting
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

        $standardArticles = DB::table('avoir_article')
            ->where('avoir_id', $id)
            ->join('articles', 'avoir_article.article_id', '=', 'articles.id')
            ->select('articles.id', 'articles.designation as produit', 'avoir_article.quantite as quantite', 'avoir_article.prix_article as prix')
            ->get()
            ->toArray();

        $customArticles = DB::table('avoir_custom_articles')
            ->where('avoir_id', $id)
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
