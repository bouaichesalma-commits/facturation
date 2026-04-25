<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Agence;
use App\Models\Projet;
use App\Models\Paiement;
use NumberToWords\NumberToWords;
use App\Http\Requests\DevisRequest;
use App\Models\Article;
use App\Models\BonDeLivraison;
use App\Models\BonDeSortie;
use App\Models\Client;
use App\Models\Facture;
use App\Models\FactureProforma;
use App\Models\Objectif;
use App\Models\OffreCommerciale;
use App\Models\RecuDePaiement;
use App\Models\DevisArticle;
use App\Models\CustomDevisArticle;
use App\Models\CategorieProduit;
use App\Models\Fournisseur ;
use App\Models\Marque;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $this->authorize('viewAny', Devis::class);
    // Add eager loading for client to solve N+1 queries, and paginate to limit memory usage
    $deviss = Devis::with('client')->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
    $latestDevis = $deviss->items()[0] ?? null; // Fetch the first item from the paginated collection

    $agence = Agence::first(); // Retrieve the Agence model (for example, to get the logo)

    return response()->view('devis.index', compact('deviss', 'latestDevis', 'agence'));
}

    
    /**
     * Show the form for creating a new resource.
     */ 
    public function create()
{
    $this->authorize('create', Devis::class);
    $clients = Client::select('id', 'nom')->get();
    $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
    
    $fournisseurs = Fournisseur::select('id', 'nom')->get();
    $marques = Marque::select('id', 'nom')->get();
    $categories = CategorieProduit::select('id', 'categorie')->get();

    $agence = Agence::first(); // Retrieve the Agence model for the logo or other data

        $marques = Marque::all();
    return response()->view('devis.create', compact('articles', 'clients', 'agence' , 'categories','fournisseurs','marques'));
}

    /**
     * Store a newly created resource in storage.
     */
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
            \Illuminate\Validation\Rule::unique('devis')->where(function ($query) use ($request) {
                return $query->whereYear('date', date('Y', strtotime($request->date)));
            })
        ],
        'date' => 'required|date',
        'articles' => 'required|json', 
        'montant' => 'required|numeric',
        'remise' => 'nullable|numeric|min:0',
        'nom_commercial' => 'nullable|string|max:255', 
        'valeurTVA' => 'nullable|numeric',
        'totalTTC' => 'required|numeric',
        
    ]);
    // dd($request->remise) ;

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

        $devis = Devis::create([
            'client_id' => $request->client,
            'num' => $formattedNum,
            'date' => $request->date,
            'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
            'taux' => $request->taux ?? 0,
            'montant' => $request->montant,
            'remise' => $request->remise ?? 0,
            'etatremise' => $request->etatremise,
            'nom_commercial' => $request->nom_commercial,
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
                DB::table('devis_article')->insert([
                    'devis_id' => $devis->id,
                    'article_id' => $existingArticle->id,
                    'quantity' => $articleData['quantite'],
                     'prix' => $articleData['prix'],
                    // 'total' => $articleData['quantite'] * $articleData['prix'],
                ]);

                //  $existingArticle->decrement('Quantite', $articleData['quantite']);
            } else {
                DB::table('custom_devis_articles')->insert([
                    'devis_id' => $devis->id,
                    'name' => $produitName,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                    // 'total' => $articleData['quantite'] * $articleData['prix'],
                ]);
            }
        }

        DB::commit();
        return redirect()->route('devis.index')->with('info', 'Devis créé avec succès.');
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
   public function edit(Devis $devi)
{
    // Get only essential columns for better performance
    $clients = Client::select('id', 'nom')->get();
    $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
    $fournisseurs = Fournisseur::select('id', 'nom')->get();
    $marques = Marque::select('id', 'nom')->get();
    $categories = CategorieProduit::select('id', 'categorie')->get();
    
    // Get articles associated with this devis
    $devisArticles = [];
    
    // Get standard articles
    $standardArticles = DB::table('devis_article')
        ->where('devis_id', $devi->id)
        ->join('articles', 'devis_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'devis_article.quantity as quantite', 'devis_article.prix')
        ->get()
        ->toArray();
    
    // Get custom articles
    $customArticles = DB::table('custom_devis_articles')
        ->where('devis_id', $devi->id)
        ->select('name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();
    
    // Combine both types of articles
    $devisArticles = array_merge($standardArticles, $customArticles);
    
    return view('devis.edit', compact('devi', 'clients', 'articles', 'devisArticles','categories','fournisseurs','marques'));
}

public function update(Request $request, Devis $devi)
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

    //dd($devi->id);
    $request->validate([
        'client' => 'required|exists:clients,id',
        'num' => [
            'required',
            'string',
            \Illuminate\Validation\Rule::unique('devis')->where(function ($query) use ($request) {
                return $query->whereYear('date', date('Y', strtotime($request->date)));
            })->ignore($devi->id)
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

        // Update the devis
        $devi->update([
            'client_id' => $request->client,
            'num' => $formattedNum,
            'date' => $request->date,
            'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
            'taux' => $request->taux ?? 0,
            'montant' => $request->montant,
            'remise' => $request->remise ?? 0,
            'etatremise' => $request->etatremise ,
             'nom_commercial' => $request->nom_commercial,
        ]);
       

        // Delete existing articles
        DB::table('devis_article')->where('devis_id', $devi->id)->delete();
        DB::table('custom_devis_articles')->where('devis_id', $devi->id)->delete();

        // Add new articles
        $articles = json_decode($request->articles, true);

        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {
                DB::table('devis_article')->insert([
                    'devis_id' => $devi->id,
                    'article_id' => $existingArticle->id,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            } else {
                DB::table('custom_devis_articles')->insert([
                    'devis_id' => $devi->id,
                    'name' => $produitName,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }
        }

        DB::commit();
        return redirect()->route('devis.index')->with('info', 'Devis mis à jour avec succès.');
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
            $devis = Devis::findOrFail($id);
            $this->authorize('delete', $devis);
            $devis->delete();
            return redirect()->route('devis.index')->with('success', 'Devis supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }
    
    
    
    public function duplicate(Devis $devis)
{
    $this->authorize('create', Devis::class);

    DB::beginTransaction();

    try {
        // Generate new unique number
        $originalNum = $devis->num;
        $counter = 1;
        do {
            $newNumParts = explode('/', $originalNum);
            $newNum = $newNumParts[0] . '-COPY-' . $counter . '/' . ($newNumParts[1] ?? date('y'));
            $counter++;
        } while (Devis::where('num', $newNum)->whereYear('date', date('Y'))->exists());

        // Create new devis
        $newDevis = $devis->replicate();
        $newDevis->num = $newNum;
        $newDevis->date = now();
        $newDevis->etat = '0'; // Reset state to initial
        $newDevis->save();

        // Duplicate standard articles
        $standardArticles = DB::table('devis_article')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($standardArticles as $article) {
            DB::table('devis_article')->insert([
                'devis_id' => $newDevis->id,
                'article_id' => $article->article_id,
                'quantity' => $article->quantity,
                'prix' => $article->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Duplicate custom articles
        $customArticles = DB::table('custom_devis_articles')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($customArticles as $custom) {
            DB::table('custom_devis_articles')->insert([
                'devis_id' => $newDevis->id,
                'name' => $custom->name,
                'quantity' => $custom->quantity,
                'prix' => $custom->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        return redirect()->route('devis.index')
            ->with('success', 'Devis dupliqué avec succès. Nouveau numéro: ' . $newNum);
    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error($e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
}

    
    
    public function updateEtat($id, Request $request)
{
    try {
        $devis = Devis::findOrFail($id);
        $devis->etat = $request->etat;
        $devis->save();
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error($e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getDevisData($id);
        
        $html = view('devis.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Devis " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download(string $id)
    {
        $data = $this->getDevisData($id);
        return response()->view('devis.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getDevisData($id)
    {
        $devis = Devis::findOrFail($id);
        $this->authorize('imprimer', $devis);
        $agence = Agence::first();
        
        $enteredNum = $devis['num'];
        if (strpos($enteredNum, '/') === false) {
            $currentYear = date('Y', strtotime($devis['date']));
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
        
        $client = $devis['client']['nom'];
        $ice = $devis['client']['ice'];
        $tel = $devis['client']['tel'];
        $adresse = $devis['client']['adresse'];
        $email = $devis['client']['email'];
        $date = date_format(date_create($devis['date']), 'd / m / Y');

        $standardArticles = DB::table('devis_article')
            ->where('devis_id', $id)
            ->join('articles', 'devis_article.article_id', '=', 'articles.id')
            ->select('articles.id', 'articles.designation as produit', 'devis_article.quantity as quantite', 'devis_article.prix')
            ->get()
            ->toArray();
    
        $customArticles = DB::table('custom_devis_articles')
            ->where('devis_id', $id)
            ->select('name as produit', 'quantity as quantite', 'prix')
            ->get()
            ->toArray();
    
        $articles = array_merge($standardArticles, $customArticles);

        $commercial = $devis['nom_commercial'];
        $total_ht = (float)$devis['montant'];
        $tva = $devis['tva'];
        $taux = $devis['taux'];
        
        $total_Remise = 0;
        $Remise = $devis['remise'];
        $Etat_remise = $devis["etatremise"];

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
        $paiements = Paiement::all();
       
        return compact(
            "agence", "numero", "commercial", "client", "ice", "date", "articles", 
            "total_ht", 'tva', 'taux', "total_tva", "total_ttc", "total_words", 
            "paiements", "total_Remise", "Remise", "total_ht_avec_remise", 
            "Etat_remise", "tel", "adresse", "email", "devis"
        );
    }


    
    public function converttoFacture(Request $request , string $id)
    {
        $request->validate([
            'paiement' => 'required',
            'montantPaiy'=>['required_if:typeMpaiy,=,on']
        ]);

        $devis = Devis::findOrFail($id);
        $this->authorize('convert', $devis);
        $facturenum = Facture::where('num','=',$devis->num)->first();
        // dd($facturenum);
        if (empty($facturenum)) {
            # code...
             DB::beginTransaction();
        
        $facture = new Facture();
        $facture->client()->associate($devis->client()->first()->id);
        $facture->paiement()->associate($request->input('paiement'));
        
        $facture->fill([
            'num' => $devis->num,
            'date' => $devis->date,
            'client_id' => $devis->client_id,
            'paiement_id' => $request->input('paiement'),
            // 'objectif' => $devis->objectif,
            'etat' => $request->input('etat'),
            'montant' => $devis->montant,
            'remise'=>$devis->remise,
            'etatremise'=>$devis->etatremise,
            'montantPaiy' => $request->input('montantPaiy'),
            'typeMpaiy' => $request->input('typeMpaiy'),
        ])->save();
        
      // Process standard articles
        $standardArticles = DB::table('devis_article')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($standardArticles as $article) {
            DB::table('facture_article')->insert([
                'facture_id' => $facture->id,
                'article_id' => $article->article_id,
                'prix' =>$article->prix ,
                'quantity' => $article->quantity,
                'insertion_order' => $article->insertion_order,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Process custom articles
        $customArticles = DB::table('custom_devis_articles')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($customArticles as $custom) {
            DB::table('custom_facture_articles')->insert([
                'facture_id' => $facture->id,
                'name' => $custom->name,
                'quantite' => $custom->quantity,
                'prix' => $custom->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
         DB::commit();

        return redirect('/devis')->with('info', 'The devis has been successfully converted to an invoice (facture) !');
    }else{

        return redirect('/devis')->with('worning', 'The device has already been converted to an invoice (facture) !');
    }

    }

  public function converttoFactureProforma(Request $request, string $id)
{
    $request->validate([
        'paiement' => 'required',
        'montantPaiy' => ['required_if:typeMpaiy,=,on']
    ]);

    $devis = Devis::findOrFail($id);
    $this->authorize('convert', $devis);
    $proformaNum = FactureProforma::where('num', '=', $devis->num)->first();
    
    if (empty($proformaNum)) {
        DB::beginTransaction();
        
        $proforma = new FactureProforma();
        $proforma->client()->associate($devis->client()->first()->id);
        $proforma->paiement()->associate($request->input('paiement'));
        
        $proforma->fill([
            'num' => $devis->num,
            'date' => $devis->date,
            'client_id' => $devis->client_id,
            'paiement_id' => $request->input('paiement'),
            'etat' => $request->input('etat'),
            'montant' => $devis->montant,
            'montantPaiy' => $request->input('montantPaiy'),
            'typeMpaiy' => $request->input('typeMpaiy'),
            'tva' => 20 ,
            'taux' => $devis->taux,
            'remise' => $devis->remise,
            'etatremise' => $devis->etatremise,
        ])->save();
        
        // Process standard articles
        $standardArticles = DB::table('devis_article')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($standardArticles as $article) {
            DB::table('facture_proforma_articles')->insert([
                'facture_proforma_id' => $proforma->id,
                'article_id' => $article->article_id,
                'quantity' => $article->quantity,
                'prix'=> $article->prix,
                'insertion_order' => $article->insertion_order,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Process custom articles
        $customArticles = DB::table('custom_devis_articles')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($customArticles as $custom) {
            DB::table('custom_product_facture_proforma')->insert([
                'facture_proforma_id' => $proforma->id,
                'name' => $custom->name,
                'quantity' => $custom->quantity,
                'prix' => $custom->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        DB::commit();
        return redirect('/devis')->with('info', 'The devis has been successfully converted to a proforma invoice!');
    } else {
        return redirect('/devis')->with('warning', 'This devis has already been converted to a proforma invoice!');
    }
}



  public function converttobon(Request $request, string $id)
{
   

    $devis = Devis::findOrFail($id);
    $this->authorize('convert', $devis);
    $bonNum = BonDeLivraison::where('num', '=', $devis->num)->first();
    
    if (empty($bonNum)) {
        DB::beginTransaction();
        
        $bon = new BonDeLivraison();
        $bon->client()->associate($devis->client()->first()->id);
       // $bon->paiement()->associate($request->input('paiement'));
        
        $bon->fill([
            'num' => $devis->num,
            'date' => $devis->date,
            'client_id' => $devis->client_id,
         
            'montant' => $devis->montant,
           
            'tva' =>  $devis->tva,
            'taux' => $devis->taux,
            'remise' => $devis->remise,
            'etatremise' => $devis->etatremise,
        ])->save();
        
        // Process standard articles
        $standardArticles = DB::table('devis_article')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($standardArticles as $article) {
            DB::table('bon_article')->insert([
                'bon_de_livraison_id' => $bon->id,
                'article_id' => $article->article_id,
                'quantite' => $article->quantity,
                'prix_article'=>$article->prix,
                
                'created_at' => now(),
                'updated_at' => now(),
            ]);


           
        }

        // Process custom articles
        $customArticles = DB::table('custom_devis_articles')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($customArticles as $custom) {
            DB::table('custom_bon_articles')->insert([
                'bon_id' => $bon->id,
                'name' => $custom->name,
                'quantity' => $custom->quantity,
                'prix' => $custom->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            
        }
        
        DB::commit();
        return redirect('/devis')->with('info', 'Le devis a été converti avec succès en un bon de livraison !');
    } else {
        return redirect('/devis')->with('warning', 'Ce devis a déjà été converti en bon de livraison !');
    }
}



 public function converttobonSortie(Request $request, string $id)
{
   

    $devis = Devis::findOrFail($id);
    $this->authorize('convert', $devis);
    $bonNum = BonDeSortie::where('num', '=', $devis->num)->first();
    
    if (empty($bonNum)) {
        DB::beginTransaction();
        
        $bon = new BonDeSortie();
        $bon->client()->associate($devis->client()->first()->id);
      
        
        $bon->fill([
            'num' => $devis->num,
            'date' => $devis->date,
            'client_id' => $devis->client_id,
         
            'etat_id' => 0 ,
            'montant' => $devis->montant,
           
            'tva' =>  $devis->tva,
            'taux' => $devis->taux,
            'remise' => $devis->remise,
            'etatremise' => $devis->etatremise,
        ])->save();
        
        // Process standard articles
        $standardArticles = DB::table('devis_article')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($standardArticles as $article) {
            DB::table('bon_sortie_article')->insert([
                'bon_id' => $bon->id,
                'article_id' => $article->article_id,
                'quantite' => $article->quantity,
                'prix_article'=>$article->prix,
                
                'created_at' => now(),
                'updated_at' => now(),
            ]);


           
        }

        // Process custom articles
        $customArticles = DB::table('custom_devis_articles')
            ->where('devis_id', $devis->id)
            ->get();

        foreach ($customArticles as $custom) {
            DB::table('bon_sortie_custom_articles')->insert([
                'bon_id' => $bon->id,
                'name' => $custom->name,
                'quantity' => $custom->quantity,
                'prix' => $custom->prix,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            
        }
        
        DB::commit();
        return redirect('/devis')->with('info', 'Le devis a été converti avec succès en un bon de Sortie !');
    } else {
        return redirect('/devis')->with('warning', 'Ce devis a déjà été converti en bon de Sortie !');
    }
}

















}




