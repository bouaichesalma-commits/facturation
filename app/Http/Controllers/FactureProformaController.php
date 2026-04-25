<?php namespace App\Http\Controllers;

use App\Http\Requests\FactureProformaRequest;
use App\Models\Agence;
use App\Models\Article;
use App\Models\Client;
use App\Models\FactureProforma;
use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Models\CategorieProduit;
use App\Models\Fournisseur;
use App\Models\Marque;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class FactureProformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', FactureProforma::class);
        $factureProformas = FactureProforma::with(['client', 'paiement', 'reglements'])->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
        return response()->view('FactureProforma.index', compact('factureProformas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', FactureProforma::class);
        $clients = Client::select('id', 'nom')->get();
        $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
        $paiements = Paiement::select('id', 'methode')->get();
    
        $fournisseurs = Fournisseur::select('id', 'nom')->get();
        $marques = Marque::select('id', 'nom')->get();
        $categories = CategorieProduit::select('id', 'categorie')->get();
        return response()->view('FactureProforma.create', compact('paiements','clients','categories','marques','fournisseurs','articles'));
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
            'num' => 'required|string',
            'date' => 'required|date',
            'paiement' => 'required|exists:paiements,id',
            'articles' => 'required|json',
            'typeMpaiy' => 'nullable|string',
            'montantPaiy' => 'nullable|numeric',
            'etat' => 'required|in:0,1',
            'remise' => 'nullable|numeric|min:0',
            'etatremise' => 'nullable|in:off,pourcentage,montant',
        ]);
        
        DB::beginTransaction();
        try {
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

            $proforma = new FactureProforma();
            $proforma->client()->associate($request->input('client'));
            $proforma->paiement()->associate($request->input('paiement'));
            
            $proformaData = $request->except(['reglements', 'montantPaiy', 'numero_cheque', 'typeMpaiy']);
            $proformaData['num'] = $formattedNum;
            
            $proformaData['montantPaiy'] = 0;
            $proformaData['numero_cheque'] = null;
            $proformaData['typeMpaiy'] = $request->has('typeMpaiy') ? 'on' : 'off';
            $proformaData['tva'] = $request->has('tva') ? ($request->taux ?? 20) : 0;
            
            $proforma->fill($proformaData)->save();

            $articles = json_decode($request->articles, true);
            foreach ($articles as $articleData) {
                $produitName = trim($articleData['produit']);
                $existingArticle = Article::where('designation', $produitName)->first();

                if ($existingArticle) {
                    DB::table('facture_proforma_articles')->insert([
                        'facture_proforma_id' => $proforma->id,
                        'article_id' => $existingArticle->id,
                        'quantity' => $articleData['quantite'],
                        'prix' => $articleData['prix'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('custom_product_facture_proforma')->insert([
                        'facture_proforma_id' => $proforma->id,
                        'name' => $produitName,
                        'quantity' => $articleData['quantite'],
                        'prix' => $articleData['prix'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            $principalAmount = floatval($request->montantPaiy ?? 0);
            if ($principalAmount > 0) {
                $proforma->reglements()->create([
                    'paiement_id' => $request->paiement,
                    'montant'     => $principalAmount,
                    'num_cheque'  => $request->numero_cheque ?? null,
                ]);
            }

            if ($request->has('reglements') && !empty($request->reglements)) {
                $reglementsList = json_decode($request->reglements, true);
                if (is_array($reglementsList)) {
                    foreach ($reglementsList as $regData) {
                        if (!empty($regData['montant']) && floatval($regData['montant']) > 0) {
                            $proforma->reglements()->create([
                                'paiement_id' => $regData['paiement_id'] ?? $request->paiement,
                                'montant'     => $regData['montant'],
                                'num_cheque'  => $regData['num_cheque'] ?? null,
                            ]);
                        }
                    }
                }
            }

            $proforma->update(['montantPaiy' => $proforma->reglements()->sum('montant')]);

            DB::commit();
            return redirect()->route('factureProforma.index')->with('success', 'Facture proforma creee avec succes.');

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
        return redirect()->route('factureProforma.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FactureProforma $factureProforma)
    {
        $clients = Client::select('id', 'nom')->get();
        $paiements = Paiement::select('id', 'methode')->get();
        $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
        $fournisseurs = Fournisseur::select('id', 'nom')->get();
        $marques = Marque::select('id', 'nom')->get();
        $categories = CategorieProduit::select('id', 'categorie')->get();

        $factureArticles = [];
        
        $standardArticles = DB::table('facture_proforma_articles')
            ->where('facture_proforma_id', $factureProforma->id)
            ->join('articles', 'facture_proforma_articles.article_id', '=', 'articles.id')
            ->select('articles.id', 'articles.designation as produit', 'facture_proforma_articles.quantity as quantite', 'facture_proforma_articles.prix')
            ->get()
            ->toArray();
        
        $customArticles = DB::table('custom_product_facture_proforma')
            ->where('facture_proforma_id', $factureProforma->id)
            ->select(DB::raw('NULL as id'), 'name as produit', 'quantity as quantite', 'prix')
            ->get()
            ->toArray();
        
        $factureArticles = array_merge($standardArticles, $customArticles);
        $reglements = $factureProforma->reglements;

        return view('FactureProforma.edit', compact(
            'factureProforma',
            'clients', 'paiements','articles', 'fournisseurs',
            'marques',
            'categories',
            'factureArticles',
            'reglements'
        ));
    }

    public function update(Request $request, FactureProforma $factureProforma)
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
            'num' => 'required|string|unique:facture_proformas,num,' .$factureProforma->id,
            'date' => 'required|date',
            'paiement' => 'required|exists:paiements,id',
            'articles' => 'required|json',
            'montant' => 'required|numeric',
            'typeMpaiy' => 'nullable|string',
            'montantPaiy' => 'nullable|numeric',
            'etat' => 'required|in:0,1',
            'remise' => 'nullable|numeric|min:0',
            'etatremise' => 'nullable|in:off,pourcentage,montant',
        ]);

        DB::beginTransaction();

        try {
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

            $factureProforma->update([
                'client_id' => $request->client,
                'paiement_id' => $request->paiement,
                'num' => $formattedNum,
                'date' => $request->date,
                'tva' => $request->has('tva') ? ($request->taux ?? 20) : 0,
                'montant' => $request->montant,
                'typeMpaiy' => $request->has('typeMpaiy') ? 'on' : 'off',
                'etat' => $request->etat,
                'remise' => $request->remise,
                'etatremise' => $request->etatremise,
            ]);

            DB::table('facture_proforma_articles')->where('facture_proforma_id', $factureProforma->id)->delete();
            DB::table('custom_product_facture_proforma')->where('facture_proforma_id', $factureProforma->id)->delete();

            $articles = json_decode($request->articles, true);

            foreach ($articles as $articleData) {
                $produitName = trim($articleData['produit']);
                $existingArticle = Article::where('designation', $produitName)->first();

                if ($existingArticle) {
                    DB::table('facture_proforma_articles')->insert([
                        'facture_proforma_id' => $factureProforma->id,
                        'article_id' => $existingArticle->id,
                        'quantity' => $articleData['quantite'],
                        'prix' => $articleData['prix'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('custom_product_facture_proforma')->insert([
                        'facture_proforma_id' => $factureProforma->id,
                        'name' => $produitName,
                        'quantity' => $articleData['quantite'],
                        'prix' => $articleData['prix'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            $factureProforma->reglements()->delete();

            $reglementsSaved = false;
            if ($request->has('reglements') && !empty($request->reglements)) {
                $reglementsList = json_decode($request->reglements, true);
                foreach ($reglementsList as $regData) {
                    if (!empty($regData['paiement_id']) && !empty($regData['montant'])) {
                        $factureProforma->reglements()->create([
                            'paiement_id' => $regData['paiement_id'],
                            'montant'     => $regData['montant'],
                            'num_cheque'  => $regData['num_cheque'] ?? null,
                        ]);
                        $reglementsSaved = true;
                    }
                }
            }

            if (!$reglementsSaved) {
                $principalAmount = floatval($request->montantPaiy ?? 0);
                if ($principalAmount > 0) {
                    $factureProforma->reglements()->create([
                        'paiement_id' => $request->paiement,
                        'montant'     => $principalAmount,
                        'num_cheque'  => $request->numero_cheque ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('factureProforma.index')->with('success', 'Facture proforma mise a jour avec succes.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $factureProforma = FactureProforma::findOrFail($id);
            $this->authorize('delete', $factureProforma);
            $factureProforma->delete();
            return redirect()->route('factureProforma.index')->with('success', 'Facture proforma supprimée avec succès.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in FactureProformaController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la facture proforma.');
        }
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getProformaData($id);
        
        $html = view("FactureProforma.pdf", $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set("isRemoteEnabled", false); 
        $options->set("isHtml5ParserEnabled", true);
        $options->set("chroot", public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper("A4", "portrait");
        $dompdf->render();
        
        $filename = "Proforma " . str_replace("/", " ", $data["numero"]);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download(string $id)
    {
        $data = $this->getProformaData($id);
        return response()->view("FactureProforma.download", $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getProformaData($id)
    {
        $agence = Agence::first();
        $factureProforma = FactureProforma::findOrFail($id);
        $this->authorize("imprimer", $factureProforma);
        
        $enteredNum = strval($factureProforma["num"]);
        if (strpos($enteredNum, "/") === false) {
            $currentYear = date("Y", strtotime($factureProforma["date"]));
            $numero = sprintf("%05d/%s", (int)$enteredNum, $currentYear);
        } else {
            $parts = explode("/", $enteredNum);
            $numericPart = (int)$parts[0];
            $yearPart = $parts[1];
            if (strlen($yearPart) == 2) {
                $yearPart = "20" . $yearPart;
            }
            $numero = sprintf("%05d/%s", $numericPart, $yearPart);
        }

        $client = $factureProforma["client"]["nom"];
        $tel = $factureProforma["client"]["tel"];
        $email = $factureProforma["client"]["email"];
        $adresse = $factureProforma["client"]["adresse"];
        $ice = $factureProforma["client"]["ice"];
        $date = date_format(date_create($factureProforma["date"]), "d / m / Y");

        $num_ch = null;
        $m_ch = null;
        
        if ($factureProforma["paiement"]["methode"] == "Chèque") {
            $num_ch = $factureProforma["numero_cheque"];
        }

        $standardArticles = DB::table("facture_proforma_articles")
            ->where("facture_proforma_id", $id)
            ->join("articles", "facture_proforma_articles.article_id", "=", "articles.id")
            ->select("articles.id", "articles.designation as produit", "facture_proforma_articles.quantity as quantite", "facture_proforma_articles.prix")
            ->get()
            ->toArray();
        
        $customArticles = DB::table("custom_product_facture_proforma")
            ->where("facture_proforma_id", $id)
            ->select(DB::raw("NULL as id"), "name as produit", "quantity as quantite", "prix")
            ->get()
            ->toArray();
        
        $factureArticles = array_merge($standardArticles, $customArticles);

        $total_ht = (float)$factureProforma["montant"];
        $typeMpaiy = $factureProforma["typeMpaiy"];
        $tva = $factureProforma["tva"];
      
        $total_Remise = 0;
        $Remise = $factureProforma["remise"];
        $Etat_remise = $factureProforma["etatremise"];

        if ($Etat_remise == "pourcentage") {
            $total_Remise = $total_ht * ($Remise / 100);
        } else if($Etat_remise == "montant"){
            $total_Remise = $Remise;
        }
        
        $tot = $total_ht - $total_Remise;
        
        // Use the saved tva value as the rate. If it's 1 (legacy status), treat as 20.
        $rate = (float)$tva;
        if ($rate == 1) {
            $rate = 20;
        }
        
        $total_tva = $rate > 0 ? ($tot * ($rate / 100)) : 0;
        $total_ht_avec_remis = $total_ht - $total_Remise;

        $total_ttc = $total_ht - $total_Remise + $total_tva;
        
        // Pass the actual rate to the view as 'taux'
        $taux = $rate; 
        $total_cents = (int) round($total_ttc * 100);
        $total_words = strtoupper(NumberToWords::transformCurrency("fr", $total_cents, "MAD"));
        $paiement = $factureProforma["paiement"]["methode"];
        
        $reglements = $factureProforma->reglements()->with("paiement")->get();
    
        return compact(
            "agence", "numero", "client", "ice", "date", "factureArticles", 
            "total_ht", "tva", "total_tva", "total_ttc", "total_words", 
            "paiement", "typeMpaiy", "total_Remise", "Remise", "adresse", 
            "email", "tel", "total_ht_avec_remis", "Etat_remise", "reglements", 
            "num_ch", "m_ch", "factureProforma", "taux"
        );
    }
}