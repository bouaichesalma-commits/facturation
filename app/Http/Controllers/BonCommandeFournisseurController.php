<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\BonCommandeFournisseur;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Agence;
use App\Models\CategorieProduit;
use App\Models\Marque;

class BonCommandeFournisseurController extends Controller
{
    public function index()
    {
        $bonCommandeFournisseurs = \App\Models\BonCommandeFournisseur::with('fournisseur')->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
        $latestBon = $bonCommandeFournisseurs->items()[0] ?? null;
        $agence = \App\Models\Agence::first();

        return view('bon_commande_fournisseur.index', compact('bonCommandeFournisseurs', 'latestBon', 'agence'));
    }

    public function create()
    {
        $fournisseurs = \App\Models\Fournisseur::select('id', 'nom')->get();
        $articles = \App\Models\Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
        $marques = \App\Models\Marque::select('id', 'nom')->get();
        $categories = \App\Models\CategorieProduit::select('id', 'categorie')->get();
        $agence = \App\Models\Agence::first();

        return view('bon_commande_fournisseur.create', compact('articles', 'fournisseurs', 'agence', 'categories', 'marques'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fournisseur' => 'required',
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
            'fournisseur' => 'required|exists:fournisseurs,id',
            'num' => [
                'required',
                'string',
                Rule::unique('bon_commande_fournisseurs')->where(function ($query) use ($request) {
                    return $query->whereYear('date', date('Y', strtotime($request->date)));
                })
            ],
            'date' => 'required|date',
            'montant' => 'required|numeric',
            'remise' => 'nullable|numeric|min:0',
            'valeurTVA' => 'nullable|numeric',
            'totalTTC' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Handle devis num formatting
            $enteredNum = strval($request->num);
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

            $bon = BonCommandeFournisseur::create([
                'fournisseur_id' => $request->fournisseur,
                'num' => $formattedNum,
                'date' => $request->date,
                'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0, 
                'taux' => $request->taux ?? 0,
                'remise' => $request->remise ?? 0,
                'etatremise' => $request->etatremise,
                'etat' => 0,
                'montant' => $request->montant,
            ]);

            foreach ($articles as $articleData) {
                $produitName = trim($articleData['produit']);
                $existingArticle = \App\Models\Article::where('designation', $produitName)->first();

                \App\Models\BonCommandeFournisseurArticle::create([
                    'bon_commande_fournisseur_id' => $bon->id,
                    'article_id' => $existingArticle ? $existingArticle->id : null,
                    'produit' => $existingArticle ? null : $produitName,
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }

            DB::commit();
            return redirect()->route('bon_commande_fournisseur.index')->with('info', 'Bon de commande fournisseur créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function show($id)
    {
        $bon_commande_fournisseur = \App\Models\BonCommandeFournisseur::with(['fournisseur', 'articles', 'articles.article'])->findOrFail($id);
        $bon_commande_fournisseur_id = $bon_commande_fournisseur->id;
        $agence = \App\Models\Agence::first();

        // Format articles for view
        $bonArticles = [];
        foreach($bon_commande_fournisseur->articles as $art) {
            $bonArticles[] = (object) [
                'produit' => $art->article_id ? $art->article->designation : $art->produit,
                'quantite' => $art->quantite,
                'prix' => $art->prix
            ];
        }

        return view('bon_commande_fournisseur.show', compact('bon_commande_fournisseur', 'bon_commande_fournisseur_id', 'agence', 'bonArticles'));
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getBonData($id);
        
        $html = view('bon_commande_fournisseur.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Bon de Commande Fournisseur " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getBonData($id)
    {
        $bon = \App\Models\BonCommandeFournisseur::with('fournisseur')->findOrFail($id);
        $agence = \App\Models\Agence::first();
        
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
        
        $fournisseur = $bon->fournisseur ? $bon->fournisseur->nom : 'Inconnu';
        $ice = $bon->fournisseur ? $bon->fournisseur->ice : null;
        $tel = $bon->fournisseur ? $bon->fournisseur->telephone : null;
        $adresse = $bon->fournisseur ? $bon->fournisseur->adresse : null;
        $email = $bon->fournisseur ? $bon->fournisseur->email : null;
        
        $date = date_format(date_create($bon->date), 'd / m / Y');

        $articles = [];
        foreach($bon->articles as $art) {
            $articles[] = (object) [
                'produit' => $art->article_id ? $art->article->designation : $art->produit,
                'quantite' => $art->quantite,
                'prix' => $art->prix
            ];
        }

        $total_ht = (float)$bon->montant;
        $tva = $bon->tva;
        $taux = $bon->taux;
        
        $Remise = $bon->remise;
        $Etat_remise = $bon->etatremise;
        
        $total_Remise = 0;
        if ($Etat_remise == "percentage" || $Etat_remise == "pourcentage") {
            $total_Remise = $total_ht * ($Remise / 100);
        } else if($Etat_remise == "montant" || $Etat_remise == "fixed") {
            $total_Remise = $Remise;
        }
        
        $tot = $total_ht - $total_Remise ;
        $total_tva = $tva ? ($tot * ($taux / 100)) : 0;
        $total_ht_avec_remise = $total_ht - $total_Remise;

        $total_ttc = $tot + $total_tva; 
        $total_words = strtoupper(\NumberToWords\NumberToWords::transformCurrency('fr', (int) round($total_ttc * 100), 'MAD'));
       
        return compact(
            "agence", "numero", "fournisseur", "ice", "date", "articles", 
            "total_ht", "tva", "taux", "total_tva", "total_ttc", "total_words", 
            "total_Remise", "Remise", "total_ht_avec_remise", "Etat_remise", 
            "tel", "adresse", "email", "bon"
        );
    }

    public function edit(\App\Models\BonCommandeFournisseur $bon_commande_fournisseur)
    {
        $fournisseurs = \App\Models\Fournisseur::select('id', 'nom')->get();
        $articles = \App\Models\Article::select('id', 'designation', 'prix', 'fournisseur_id', 'marque_id', 'categorieproduit_id')->get();
        $marques = \App\Models\Marque::select('id', 'nom')->get();
        $categories = \App\Models\CategorieProduit::select('id', 'categorie')->get();
        
        $bon_commande_fournisseur->load('articles.article');
        $bonCommandeArticles = [];
        foreach($bon_commande_fournisseur->articles as $item) {
            $bonCommandeArticles[] = [
                'id' => $item->article_id,
                'produit' => $item->article_id ? optional($item->article)->designation : $item->produit,
                'quantite' => $item->quantite,
                'prix' => $item->prix
            ];
        }

        return view('bon_commande_fournisseur.edit', compact('bon_commande_fournisseur', 'fournisseurs', 'articles', 'bonCommandeArticles', 'categories', 'marques'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\BonCommandeFournisseur $bon_commande_fournisseur)
    {
        $request->validate([
            'fournisseur' => 'required|exists:fournisseurs,id',
            'num' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('bon_commande_fournisseurs')->where(function ($query) use ($request) {
                    return $query->whereYear('date', date('Y', strtotime($request->date)));
                })->ignore($bon_commande_fournisseur->id)
            ],
            'date' => 'required|date',
            'articles' => 'required|json',
            'montant' => 'required|numeric',
            'remise' => 'nullable|numeric|min:0',
            'valeurTVA' => 'nullable|numeric',
            'totalTTC' => 'required|numeric',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $enteredNum = strval($request->num);
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

            $bon_commande_fournisseur->update([
                'fournisseur_id' => $request->fournisseur,
                'num' => $formattedNum,
                'date' => $request->date,
                'tva' => ($request->tva === 'on' || $request->tva == 1 || $request->tva === '1') ? 1 : 0,
                'taux' => $request->taux ?? 0,
                'montant' => $request->montant,
                'remise' => $request->remise ?? 0,
                'etatremise' => $request->etatremise,
            ]);

            $bon_commande_fournisseur->articles()->delete();

            $articles = json_decode($request->articles, true);
            foreach ($articles as $articleData) {
                $produitName = trim($articleData['produit']);
                $existingArticle = \App\Models\Article::where('designation', $produitName)->first();

                \App\Models\BonCommandeFournisseurArticle::create([
                    'bon_commande_fournisseur_id' => $bon_commande_fournisseur->id,
                    'article_id' => $existingArticle ? $existingArticle->id : null,
                    'produit' => $existingArticle ? null : $produitName,
                    'quantite' => $articleData['quantite'],
                    'prix' => $articleData['prix'],
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('bon_commande_fournisseur.index')->with('info', 'Bon de commande fournisseur mis à jour avec succès.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function destroy($id)
    {
        try {
            $bon = \App\Models\BonCommandeFournisseur::findOrFail($id);
            $bon->delete();
            return redirect()->route('bon_commande_fournisseur.index')->with('success', 'Bon de commande fournisseur supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function duplicate(\App\Models\BonCommandeFournisseur $bon_commande_fournisseur)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $originalNum = $bon_commande_fournisseur->num;
            $counter = 1;
            do {
                $newNumParts = explode('/', $originalNum);
                $newNum = $newNumParts[0] . '-COPY-' . $counter . '/' . ($newNumParts[1] ?? date('y'));
                $counter++;
            } while (\App\Models\BonCommandeFournisseur::where('num', $newNum)->whereYear('date', date('Y'))->exists());

            $newBon = $bon_commande_fournisseur->replicate();
            $newBon->num = $newNum;
            $newBon->date = now();
            $newBon->etat = 0;
            $newBon->save();

            foreach ($bon_commande_fournisseur->articles as $art) {
                $newBon->articles()->create([
                    'article_id' => $art->article_id,
                    'produit' => $art->produit,
                    'quantite' => $art->quantite,
                    'prix' => $art->prix,
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('bon_commande_fournisseur.index')
                ->with('success', 'Bon de commande dupliqué avec succès. Nouveau numéro: ' . $newNum);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }


    /**
     * Show the web preview of the document
     */
    public function download($id)
    {
        $data = $this->getBonData($id);
        return view('bon_commande_fournisseur.download', $data);
    }
}
