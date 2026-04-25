<?php

namespace App\Http\Controllers;

use App\Models\Agence;

use App\Models\Projet;
use App\Models\devis;
use App\Models\Paiement;
use NumberToWords\NumberToWords;
use App\Http\Requests\FactureRequest;
use App\Models\Client;
use App\Models\Article;
use App\Models\FactureArticle;
use App\Models\CustomFactureArticle;
use App\Models\Facture;
use App\Models\FactureProforma;
use App\Models\Objectif;
use App\Models\OffreCommerciale;
use App\Models\RecuDePaiement;
use App\Models\CategorieProduit;
use App\Models\Fournisseur;
use App\Models\Marque;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Facture::class);

        if ($request->ajax()) {
            $data = Facture::select('factures.*')->with(['client', 'paiement', 'reglements']);

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $data->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('num', function ($row) {
                    return $row->num;
                })
                ->addColumn('client_nom', function ($row) {
                    return $row->client->nom ?? '';
                })
                ->editColumn('montant', function ($row) {
                    return number_format($row->montant, 2, '.', '');
                })
                ->editColumn('etat', function ($row) {
                    return $row->etat ? "<span class='badge rounded-pill badge-bg-primary'>Payée</span>" : "<span class='badge rounded-pill badge-bg-warning'>Impayée</span>";
                })
                ->editColumn('montantPaiy', function ($row) {
                    return number_format($row->montantPaiy, 2, '.', '');
                })
                ->editColumn('date', function ($row) {
                    return date_format(date_create($row->date), 'd-m-Y');
                })
                ->addColumn('action', function ($row) {
                    return view('livewire.facture-component', ['facture_id' => $row->id, 'facture' => $row])->render();
                })
                ->filterColumn('client_nom', function($query, $keyword) {
                    $query->whereHas('client', function($q) use($keyword) {
                        $q->where('nom', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('date', function($query, $keyword) {
                    $sql = "DATE_FORMAT(date, '%d-%m-%Y')  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->orderColumn('client_nom', function($query, $order) {
                    $query->join('clients', 'factures.client_id', '=', 'clients.id')
                          ->orderBy('clients.nom', $order);
                })
                ->rawColumns(['etat', 'action'])
                ->make(true);
        }

        // Keep the paginated return for the non-AJAX initial load if needed, 
        // though DataTables will replace it soon anyway.
        $factures = Facture::with(['client', 'paiement', 'reglements'])->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
        return response()->view('facture.index', compact('factures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Facture::class);
        $clients = Client::select('id', 'nom')->get();
        $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
        $paiements = Paiement::select('id', 'methode')->get();
        $fournisseurs = Fournisseur::select('id', 'nom')->get();
        $marques = Marque::select('id', 'nom')->get();
        $categories = CategorieProduit::select('id', 'categorie')->get();
        // $objectifs = Objectif::distinct()->get();
        return response()->view('facture.create', compact('paiements', 'clients', 'articles', 'categories', 'fournisseurs', 'marques'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store function
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

    $this->authorize('create', Facture::class);

    DB::beginTransaction();
    try {
        $enteredNum = $request->num;
        if (strpos($enteredNum, '/') === false) {
            $fullYear = date('Y', strtotime($request->date));
            $formattedNum = sprintf('%05d/%s', (int)$enteredNum, $fullYear);
        } else {
            $parts = explode('/', $enteredNum);
            $numericPart = (int)$parts[0];
            $yearPart = $parts[1];
            if (strlen($yearPart) == 2) {
                $yearPart = '20' . $yearPart;
            }
            $formattedNum = sprintf('%05d/%s', $numericPart, $yearPart);
        }

        $facture = new Facture();
        $facture->client()->associate($request->input('client'));
        $facture->paiement()->associate($request->input('paiement'));
        
        $factureData = $request->except(['reglements', 'montantPaiy', 'numero_cheque']);
        $factureData['num'] = $formattedNum;
        
        $factureData['montantPaiy'] = 0;
        $factureData['numero_cheque'] = null;
        $factureData['tva'] = ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0;

        $facture->fill($factureData)->save();

        // 3. Save the primary (first) payment row if montantPaiy > 0
        $principalAmount = floatval($request->montantPaiy ?? 0);
        if ($principalAmount > 0) {
            $facture->reglements()->create([
                'paiement_id' => $request->paiement,
                'montant'     => $principalAmount,
                'num_cheque'  => $request->numero_cheque ?? null,
            ]);
        }

        // 4. Save any extra reglement rows from the dynamic table (always, independently)
        if ($request->has('reglements') && !empty($request->reglements)) {
            $reglementsList = json_decode($request->reglements, true);
            if (is_array($reglementsList)) {
                foreach ($reglementsList as $reglement) {
                    if (!empty($reglement['montant']) && floatval($reglement['montant']) > 0) {
                        $facture->reglements()->create([
                            'paiement_id' => $reglement['paiement_id'] ?? $request->paiement,
                            'montant'     => $reglement['montant'],
                            'num_cheque'  => $reglement['num_cheque'] ?? null,
                        ]);
                    }
                }
            }
        }

        $articles = json_decode($request->articles, true);
        foreach ($articles as $articleData) {
            $produitName = trim($articleData['produit']);
            $existingArticle = Article::where('designation', $produitName)->first();

            if ($existingArticle) {
                DB::table('facture_article')->insert([
                    'facture_id' => $facture->id,
                    'article_id' => $existingArticle->id,
                    'quantity' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                    'delai' => null,
                ]);
            } else {
                DB::table('custom_facture_articles')->insert([
                    'facture_id' => $facture->id,
                    'name' => $produitName,
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }
        }

        // Sync montantPaiy = sum of all reglements (0 if none)
        $facture->update(['montantPaiy' => $facture->reglements()->sum('montant')]);

        DB::commit();
        return redirect()->route('facture.index')->with('info', 'Facture créé avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error("Error in FactureController@store: " . $e->getMessage());
        return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de la facture. Veuillez réessayer.');
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('facture.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facture $facture)
    {
        $clients = Client::select('id', 'nom')->get();
        $articles = Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
        $paiements = Paiement::select('id', 'methode')->get();
        $fournisseurs = Fournisseur::select('id', 'nom')->get();
        $marques = Marque::select('id', 'nom')->get();
        $categories = CategorieProduit::select('id', 'categorie')->get();

        $factureArticles = [];

        // Get standard articles
        $standardArticles = DB::table('facture_article')
            ->where('facture_id', $facture->id)
            ->join('articles', 'facture_article.article_id', '=', 'articles.id')
            ->select('articles.id', 'articles.designation as produit', 'facture_article.quantity as quantite', 'articles.prix')
            ->get()
            ->toArray();

        // Get custom articles
        $customArticles = DB::table('custom_facture_articles')
            ->where('facture_id', $facture->id)
            ->select('name as produit', 'custom_facture_articles.quantite as quantite', 'prix')
            ->get()
            ->toArray();

        // Combine both types of articles
        $factureArticles = array_merge($standardArticles, $customArticles);
        $reglements = $facture->reglements;
        return view('facture.edit', compact('facture', 'clients', 'paiements', 'articles', 'factureArticles', 'categories', 'fournisseurs', 'marques', 'reglements'));
    }

    // Update the specified facture in storage
    public function update(Request $request, Facture $facture)
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

        $request->validate(rules: [
            'client' => 'required|exists:clients,id',
            'num' => 'required|string|unique:factures,num,' . $facture->id,
            'date' => 'required|date',
            'paiement' => 'required|exists:paiements,id',

            'articles' => 'required|json',
            'montant' => 'required|numeric',
            'montantPaiy' => 'nullable|numeric',
            'etat' => 'required|in:0,1',
            'remise' => 'nullable|numeric|min:0',
            'etatremise' => 'nullable|in:off,pourcentage,montant',
            'taux' => 'required|numeric',
            'reglements' => 'nullable|json'
        ]);

        DB::beginTransaction();

        try {
            // Handle facture num formatting
            $enteredNum = $request->num;
            if (strpos($enteredNum, '/') === false) {
                $fullYear = date('Y', strtotime($request->date));
                $formattedNum = sprintf('%05d/%s', (int)$enteredNum, $fullYear);
            } else {
                $parts = explode('/', $enteredNum);
                $numericPart = (int)$parts[0];
                $yearPart = $parts[1];
                if (strlen($yearPart) == 2) {
                    $yearPart = '20' . $yearPart;
                }
                $formattedNum = sprintf('%05d/%s', $numericPart, $yearPart);
            }

            // Get principal amount entered in form
            $principalAmount = floatval($request->montantPaiy ?? 0);

            // Update the main facture (excluding montantPaiy and numero_cheque)
            $facture->update([
                'client_id' => $request->client,
                'paiement_id' => $request->paiement,
                'num' => $formattedNum,
                'date' => $request->date,
                'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
                'montant' => $request->montant,
                'etat' => $request->etat,
                'remise' => $request->remise,
                'etatremise' => $request->etatremise,
            ]);

            $facture->reglements()->delete();

            // Save the primary (first) payment row if montantPaiy > 0
            $principalAmount = floatval($request->montantPaiy ?? 0);
            if ($principalAmount > 0) {
                $facture->reglements()->create([
                    'paiement_id' => $request->paiement,
                    'montant'     => $principalAmount,
                    'num_cheque'  => $request->numero_cheque ?? null,
                ]);
            }

            // Save any extra reglement rows from the dynamic table (always, independently)
            if ($request->has('reglements') && !empty($request->reglements)) {
                $reglementsList = json_decode($request->reglements, true);
                if (is_array($reglementsList)) {
                    foreach ($reglementsList as $reglement) {
                        if (!empty($reglement['montant']) && floatval($reglement['montant']) > 0) {
                            $facture->reglements()->create([
                                'paiement_id' => $reglement['paiement_id'] ?? $request->paiement,
                                'montant'     => $reglement['montant'],
                                'num_cheque'  => $reglement['num_cheque'] ?? null,
                            ]);
                        }
                    }
                }
            }

            // Sync montantPaiy = sum of all reglements (0 if none)
            $facture->update(['montantPaiy' => $facture->reglements()->sum('montant')]);

            // Clear existing articles
            DB::table('facture_article')->where('facture_id', $facture->id)->delete();
            DB::table('custom_facture_articles')->where('facture_id', $facture->id)->delete();

            // Process new articles
            $articles = json_decode($request->articles, true);

            foreach ($articles as $articleData) {
                $produitName = trim($articleData['produit']);
                $existingArticle = Article::where('designation', $produitName)->first();

                if ($existingArticle) {
                    DB::table('facture_article')->insert([
                        'facture_id' => $facture->id,
                        'article_id' => $existingArticle->id,
                        'quantity' => $articleData['quantite'],
                        'prix' => $articleData['prix'],
                        'delai' => null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('custom_facture_articles')->insert([
                        'facture_id' => $facture->id,
                        'name' => $produitName,
                        'quantite' => $articleData['quantite'],
                        'prix' => $articleData['prix'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('facture.index')->with('success', 'Facture mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error in FactureController@update: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de la facture.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $facture = Facture::findOrFail($id);
            $this->authorize('delete', $facture);
            $facture->delete();
            return redirect()->route('facture.index')->with('success', 'Facture supprimée avec succès.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in FactureController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la facture.');
        }
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getFactureData($id);
        
        // 2. Render the PDF view to a string
        $html = view('facture.pdf', $data)->render();
        
        // 3. Initialize Dompdf with safe options
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); // Faster loading
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());  // Crucial for images
        $dompdf->setOptions($options);
        
        // 4. Generate and Stream
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Handle filename: replace slash with space to avoid OS errors
        $filename = "Facture " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download(string $id)
    {
        $data = $this->getFactureData($id);
        return response()->view('facture.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getFactureData($id)
    {
        $agence = Agence::first();
        $facture = Facture::findOrFail($id);
        $this->authorize('imprimer', $facture);
        
        // Handle facture num formatting dynamically for old/legacy entries
        $enteredNum = strval($facture['num']);
        if (strpos($enteredNum, '/') === false) {
            $fullYear = date('Y', strtotime($facture['date']));
            $numero = sprintf('%05d/%s', (int)$enteredNum, $fullYear);
        } else {
            $parts = explode('/', $enteredNum);
            $numericPart = (int)$parts[0];
            $yearPart = $parts[1];
            if (strlen($yearPart) == 2) {
                $yearPart = '20' . $yearPart;
            }
            $numero = sprintf('%05d/%s', $numericPart, $yearPart);
        }
        
        $client = $facture['client']['nom'];
        $ice = $facture['client']['ice'];
        $tel = $facture['client']['tel'];
        $email = $facture['client']['email'];
        $adresse = $facture['client']['adresse'];
        $date = date_format(date_create($facture['date']), 'd / m / Y');

        $factureArticles = [];

        // Get standard articles
        $standardArticles = DB::table('facture_article')
            ->where('facture_id', $facture->id)
            ->join('articles', 'facture_article.article_id', '=', 'articles.id')
            ->select('articles.id', 'articles.designation as produit', 'facture_article.quantity as quantite', 'facture_article.prix')
            ->get()
            ->toArray();

        // Get custom articles
        $customArticles = DB::table('custom_facture_articles')
            ->where('facture_id', $facture->id)
            ->select('name as produit', 'custom_facture_articles.quantite as quantite', 'prix')
            ->get()
            ->toArray();

        // Combine both types of articles
        $factureArticles = array_merge($standardArticles, $customArticles);
        $total_ht = (float)$facture['montant'];

        // Discount
        $total_Remise = 0;
        $Remise       = $facture['remise'];
        $Etat_remise  = $facture['etatremise'];
        if ($Etat_remise === 'pourcentage') {
            $total_Remise = $total_ht * ($Remise / 100);
        } elseif ($Etat_remise === 'montant') {
            $total_Remise = $Remise;
        }

        // TVA & Totals
        $typeMpaiy          = $facture['typeMpaiy'];
        $tva_active         = $facture['tva'];
        $tot = $total_ht - $total_Remise;
        $total_tva = $tva_active ? ($tot * (20 / 100)) : 0;
        $total_ht_avec_remis = $total_ht - $total_Remise;
        $total_ttc          = $total_ht - $total_Remise + $total_tva;

        $total_cents = (int) round($total_ttc * 100);
        $total_words = strtoupper(NumberToWords::transformCurrency('fr', $total_cents, 'MAD'));
        $paiement    = $facture['paiement']['methode'];

        // Reglements
        $reglements = $facture->reglements()->with('paiement')->get();

        $tva = $tva_active;

        return compact(
            "agence", "numero", "client", "ice", "date", "factureArticles", 
            "total_ht", "tva", "total_tva", "total_ttc", "total_words", 
            "paiement", "reglements", "typeMpaiy", "total_Remise", "Remise", 
            "total_ht_avec_remis", "Etat_remise", "email", "adresse", "tel", "facture"
        );
    }
}
