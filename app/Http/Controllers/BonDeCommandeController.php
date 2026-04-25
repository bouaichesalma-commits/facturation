<?php

namespace App\Http\Controllers;

use App\Models\BonDeCommande;
use App\Models\Agence;
use App\Models\Projet;
use App\Models\Paiement;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Requests\DevisRequest;
use App\Models\Article;

use App\Models\Client;

use App\Models\CategorieProduit;
use App\Models\Fournisseur ;
use App\Models\Marque;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class BonDeCommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $this->authorize('viewAny', BonDeCommande::class);
    // Add eager loading for client to solve N+1 queries, and paginate to limit memory usage
    $bondecommandes = BonDeCommande::with('client')->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
    $latestBonDeCommande = $bondecommandes->items()[0] ?? null; // Fetch the first item from the paginated collection

    $agence = Agence::first();

    return response()->view('bon_commande.index', compact('bondecommandes', 'latestBonDeCommande', 'agence'));
}

    
    /**
     * Show the form for creating a new resource.
     */ 
    public function create()
{
    $this->authorize('create', BonDeCommande::class);
    $clients = Client::select('id', 'nom')->get();
    $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
    
    $fournisseurs = Fournisseur::select('id', 'nom')->get();
    $marques = Marque::select('id', 'nom')->get();
    $categories = CategorieProduit::select('id', 'categorie')->get();

    $agence = Agence::first();

    $marques = Marque::all();
    return response()->view('bon_commande.create', compact('articles', 'clients', 'agence' , 'categories','fournisseurs','marques'));
}

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    $request->validate([
        'client' => 'required|exists:clients,id',
        'num' => [
            'required',
            'string',
            \Illuminate\Validation\Rule::unique('bon_de_commandes')->where(function ($query) use ($request) {
                return $query->whereYear('date', date('Y', strtotime($request->date)));
            })
        ],
        'date' => 'required|date',
        'articles' => 'required|json', 
        'montant' => 'required|numeric',
        'remise' => 'nullable|numeric|min:0',
        'valeurTVA' => 'nullable|numeric',
        'totalTTC' => 'required|numeric',
        
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

    DB::beginTransaction();

    try {
        // Handle devis num formatting (convert "1" to "00001/26" etc.)
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

        $bon = BonDeCommande::create([
            'client_id' => $request->client,
            'num' => $formattedNum,
            'date' => $request->date,
            'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0, 
            'taux' => $request->taux ?? 0,
            'etat' => 1,
            'montant' => $request->montant,
            'remise' => $request->remise ?? 0,
            'etatremise' => $request->etatremise,
        ]);
          

        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {
                DB::table('bon_de_commande_articles')->insert([
                    'bon_de_commande_id' => $bon->id,
                    'article_id' => $existingArticle->id,
                    'quantite' => $articleData['quantite'],
                     'prix' => $articleData['prix'],
                ]);
            } else {
                DB::table('bon_de_commande_articles')->insert([
                    'bon_de_commande_id' => $bon->id,
                    'produit' => $produitName,
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }
        }

        DB::commit();
        return redirect()->route('bon_commande.index')->with('info', 'Bon de commande créé avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error($e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    abort(404);
    // Retrieve the Agence data to show the logo or other information
    $agence = Agence::first();
    // You can use $agence in your view as needed.
    return response()->view('devis.show', compact('agence'));
}

    /**
     * Update the specified resource in storage.
     */
   public function edit(BonDeCommande $bon_commande)
{
    // Get only essential columns for better performance
    $clients = Client::select('id', 'nom')->get();
    $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
    $fournisseurs = Fournisseur::select('id', 'nom')->get();
    $marques = Marque::select('id', 'nom')->get();
    $categories = CategorieProduit::select('id', 'categorie')->get();
    
    // Get articles associated with this bon_commande
    // Get standard articles (from catalog)
    $standardArticles = DB::table('bon_de_commande_articles')
        ->where('bon_de_commande_id', $bon_commande->id)
        ->whereNotNull('article_id')
        ->join('articles', 'bon_de_commande_articles.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'bon_de_commande_articles.quantite', 'bon_de_commande_articles.prix')
        ->get()
        ->toArray();
    
    // Get custom articles
    $customArticles = DB::table('bon_de_commande_articles')
        ->where('bon_de_commande_id', $bon_commande->id)
        ->whereNull('article_id')
        ->select('produit', 'quantite', 'prix')
        ->get()
        ->toArray();
    
    // Combine both types of articles
    $bonCommandeArticles = array_merge($standardArticles, $customArticles);
    
    return view('bon_commande.edit', compact('bon_commande', 'clients', 'articles', 'bonCommandeArticles','categories','fournisseurs','marques'));
}

public function update(Request $request, BonDeCommande $bon_commande)
{
    $request->validate([
        'client' => 'required|exists:clients,id',
        'num' => [
            'required',
            'string',
            \Illuminate\Validation\Rule::unique('bon_de_commandes')->where(function ($query) use ($request) {
                return $query->whereYear('date', date('Y', strtotime($request->date)));
            })->ignore($bon_commande->id)
        ],
        'date' => 'required|date',
        'articles' => 'required|json',
        'montant' => 'required|numeric',
        'remise' => 'nullable|numeric|min:0',
        'nom_commercial' => 'nullable|string|max:255', 
        'valeurTVA' => 'nullable|numeric',
        'totalTTC' => 'required|numeric',
    ]);
    
    

    DB::beginTransaction();

    try {
        // Handle devis num formatting
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

        // Update the bon commande
        $bon_commande->update([
            'client_id' => $request->client,
            'num' => $formattedNum,
            'date' => $request->date,
            'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
            'taux' => $request->taux ?? 0,
            'montant' => $request->montant,
            'remise' => $request->remise ?? 0,
            'etatremise' => $request->etatremise ,
        ]);
       

        // Delete existing articles (both standard and custom, they share the same table now)
        DB::table('bon_de_commande_articles')->where('bon_de_commande_id', $bon_commande->id)->delete();

        // Add new articles
        $articles = json_decode($request->articles, true);

        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {
                DB::table('bon_de_commande_articles')->insert([
                    'bon_de_commande_id' => $bon_commande->id,
                    'article_id' => $existingArticle->id,
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            } else {
                DB::table('bon_de_commande_articles')->insert([
                    'bon_de_commande_id' => $bon_commande->id,
                    'produit' => $produitName,
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }
        }

        DB::commit();
        return redirect()->route('bon_commande.index')->with('info', 'Bon de commande mis à jour avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error($e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $bonCommande = BonDeCommande::findOrFail($id);
            $this->authorize('delete', $bonCommande);
            $bonCommande->delete();
            return redirect()->route('bon_commande.index')->with('success', 'Bon de commande supprimé avec succès.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in BonDeCommandeController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression du bon de commande.');
        }
    }
    
    
    
    public function duplicate(BonDeCommande $bon_commande)
{
    $this->authorize('create', BonDeCommande::class);

    DB::beginTransaction();

    try {
        // Generate new unique number
        $originalNum = $bon_commande->num;
        $counter = 1;
        do {
            $newNumParts = explode('/', $originalNum);
            $newNum = $newNumParts[0] . '-COPY-' . $counter . '/' . ($newNumParts[1] ?? date('y'));
            $counter++;
        } while (BonDeCommande::where('num', $newNum)->whereYear('date', date('Y'))->exists());

        // Create new bon_commande
        $newBonCommande = $bon_commande->replicate();
        $newBonCommande->num = $newNum;
        $newBonCommande->date = now();
        $newBonCommande->etat = '0'; // Reset state to initial
        $newBonCommande->save();

        // Duplicate articles (both standard and custom from single table)
        $articles = DB::table('bon_de_commande_articles')
            ->where('bon_de_commande_id', $bon_commande->id)
            ->get();

        foreach ($articles as $article) {
            DB::table('bon_de_commande_articles')->insert([
                'bon_de_commande_id' => $newBonCommande->id,
                'article_id' => $article->article_id,
                'produit' => $article->produit,
                'quantite' => $article->quantite,
                'prix' => $article->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        return redirect()->route('bon_commande.index')
            ->with('success', 'Bon de commande dupliqué avec succès. Nouveau numéro: ' . $newNum);
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error($e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
}

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getBonData($id);
        
        $html = view('bon_commande.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Bon de Commande " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download($id)
    {
        $data = $this->getBonData($id);
        return view('bon_commande.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getBonData($id)
    {
        $bon_commande = BonDeCommande::findOrFail($id);
        $agence = Agence::first();
        
        // Handle bon_commande num formatting
        $enteredNum = $bon_commande->num;
        if (strpos($enteredNum, '/') === false) {
            $currentYear = date('Y', strtotime($bon_commande->date));
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
        
        $client = $bon_commande->client->nom;
        $ice = $bon_commande->client->ice;
        $tel = $bon_commande->client->tel;
        $adresse = $bon_commande->client->adresse;
        $email = $bon_commande->client->email;
        $date = date_format(date_create($bon_commande->date), 'd / m / Y');

        $standardArticles = DB::table('bon_de_commande_articles')
              ->where('bon_de_commande_id', $id)
              ->whereNotNull('article_id')
              ->join('articles', 'bon_de_commande_articles.article_id', '=', 'articles.id')
              ->select('articles.id', 'articles.designation as produit', 'bon_de_commande_articles.quantite', 'bon_de_commande_articles.prix')
              ->get()
              ->toArray();
          
        $customArticles = DB::table('bon_de_commande_articles')
              ->where('bon_de_commande_id', $id)
              ->whereNull('article_id')
              ->select('produit', 'quantite', 'prix')
              ->get()
              ->toArray();
          
        $articles = array_merge($standardArticles, $customArticles);

        $commercial = $bon_commande->nom_commercial;
        $total_ht = (float)$bon_commande->montant;
        $tva = $bon_commande->tva;
        $taux = $bon_commande->taux;
        
        $total_Remise = 0;
        $Remise = $bon_commande->remise;
        $Etat_remise = $bon_commande->etatremise;

        if ($Etat_remise == "pourcentage") {
            $total_Remise =  $total_ht * ($Remise / 100);
        } else if($Etat_remise == "montant") {
            $total_Remise = $Remise;
        }
        
        $tot = $total_ht - $total_Remise;
        $total_tva = $tva ? ($tot * (20 / 100)) : 0;
        $total_ht_avec_remise = $total_ht - $total_Remise;

        $total_ttc = $total_ht - $total_Remise + $total_tva; 
        $total_words = strtoupper(NumberToWords::transformCurrency('fr', (int) round($total_ttc * 100), 'MAD'));
        $paiements = Paiement::all();
       
        $bonArticles = $articles;
       
        return compact(
            "agence", "numero", "commercial", "client", "ice", "date", "articles", "bonArticles",
            "total_ht", "tva", "taux", "total_tva", "total_ttc", "total_words", 
            "paiements", "total_Remise", "Remise", "total_ht_avec_remise", "Etat_remise", 
            "tel", "adresse", "email", "bon_commande"
        );
    }


    
}
