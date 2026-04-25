<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecuDePaiementRequest;
use App\Models\Agence;
use App\Models\Article;
use App\Models\Client;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\FactureProforma;
use App\Models\Objectif;
use App\Models\OffreCommerciale;
use App\Models\Paiement;
use App\Models\RecuDePaiement;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;

class RecuDePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', RecuDePaiement::class);
        $RecuDePaiements = RecuDePaiement::all();
        return response()->view('RecuDePaiement.index', compact('RecuDePaiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', RecuDePaiement::class);
        $clients = Client::all();
        $articles = Article::all();
        $objectifs = Objectif::distinct()->get();
       
        return response()->view('RecuDePaiement.create', compact('articles','clients','objectifs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecuDePaiementRequest $request)
    {
        $this->authorize('create', RecuDePaiement::class);
        DB::beginTransaction();
        try {
            $RecuDePaiement = new RecuDePaiement();
            $RecuDePaiement->client()->associate($request->input('client'));
            $RecuDePaiement->fill($request->all())->save();

            // this for insert in table RecuDePaiement_article

            $dataProdouits = json_decode($request->input('articles'), true);

            $pivot_info_articles = [];
            $insertion_order =  0;
            foreach($dataProdouits as $keyP){
                $insertion_order++;
                $pivot_info_articles[$keyP["article_id"]] = ["quantity"=>intval($keyP["quantity"]),"insertion_order"=>$insertion_order];
            }
            $RecuDePaiement->articles()->sync($pivot_info_articles);

            $objectif = Objectif::where('text','=',$request->objectif)->first();

            if(empty($objectif)){
                $objectifs = new Objectif();
                $objectifs->text = $request->objectif;
                $objectifs->save();
            }
            
            DB::commit();
            return redirect('/RecuDePaiement/create')->with('info', 'The RecuDePaiement added successfully !');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error in RecuDePaiementController@store: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement du reçu de paiement. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
        // $RecuDePaiement = RecuDePaiement::findOrFail($id);
        // return response()->view('RecuDePaiement.show', compact('RecuDePaiement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $RecuDePaiement = RecuDePaiement::findOrFail($id);
        $this->authorize('update', $RecuDePaiement);
        $clients = Client::all();
        $articles = Article::all();
        $objectifs = Objectif::distinct()->get();

        $RecuDePaiement_article = array();
        $pivot_articles = $RecuDePaiement->articles;
        foreach($pivot_articles as $article){
            array_push($RecuDePaiement_article,array("article_id"=> $article->pivot->article_id , "quantity" => $article->pivot->quantity));
        }
        
        return response()->view('RecuDePaiement.edit', compact('RecuDePaiement', 'RecuDePaiement_article','clients','articles','objectifs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecuDePaiementRequest $request, string $id)
    {
        $RecuDePaiement = RecuDePaiement::findOrFail($id);
        $this->authorize('update', $RecuDePaiement);
        DB::beginTransaction();
        try {
            $RecuDePaiement->client()->associate($request->input('client'));
            $RecuDePaiement->fill($request->all())->update();
            
            $dataProdouits = json_decode($request->input('articles'), true);

            $pivot_info_articles = [];
            $insertion_order =  0;
            foreach($dataProdouits as $keyP){
                $insertion_order++;
                $pivot_info_articles[$keyP["article_id"]] = ["quantity"=>intval($keyP["quantity"]),"insertion_order"=>$insertion_order];
            }
            $RecuDePaiement->articles()->sync($pivot_info_articles);
            
            $objectif = Objectif::where('text','=',$request->objectif)->first();

            if(empty($objectif)){
                $objectifs = new Objectif();
                $objectifs->text = $request->objectif;
                $objectifs->save();
            }

            DB::commit();
            return redirect('/RecuDePaiement/'.$id.'/edit')->with('info', 'The RecuDePaiement updated successfully !');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error in RecuDePaiementController@update: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour du reçu de paiement.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $RecuDePaiement = RecuDePaiement::findOrFail($id);
            $this->authorize('delete', $RecuDePaiement);
            $objectifText = $RecuDePaiement->objectif;
            $RecuDePaiement->delete();
            $objectifExistsInOtherRecords = Facture::where('objectif', $objectifText)->exists() ||
                                            FactureProforma::where('objectif', $objectifText)->exists()||
                                            OffreCommerciale::where('objectif', $objectifText)->exists()||
                                            Devis::where('objectif', $objectifText)->exists()||
                                            RecuDePaiement::where('objectif', $objectifText)->exists();

            if (!$objectifExistsInOtherRecords) {
                Objectif::where('text', $objectifText)->delete();
            }
            return redirect('/RecuDePaiement');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in RecuDePaiementController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression du reçu de paiement.');
        }
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getRecuData($id);
        
        $html = view('RecuDePaiement.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Recu " . str_replace('/', ' ', $data['numero']);
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download($id)
    {
        $data = $this->getRecuData($id);
        return view('RecuDePaiement.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getRecuData($id)
    {
        $agence = Agence::first();
        $RecuDePaiement = RecuDePaiement::findOrFail($id);
        
        // Handle recu num formatting
        $enteredNum = strval($RecuDePaiement->num);
        if (strpos($enteredNum, '/') === false) {
            $currentYear = date('Y', strtotime($RecuDePaiement->date));
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

        $client = $RecuDePaiement->client->nom;
        $objet = $RecuDePaiement->objectif;
        $ice = $RecuDePaiement->client->ice;
        $tel = $RecuDePaiement->client->tel;
        $adresse = $RecuDePaiement->client->adresse;
        $email = $RecuDePaiement->client->email;
        $date = date_format(date_create($RecuDePaiement->date), 'd / m / Y');
        
        $articles = $RecuDePaiement->articles;
        $total_ht = (float)$RecuDePaiement->montant;
        $tva = $RecuDePaiement->tva;
        $taux = $RecuDePaiement->taux;
        $Remise = $RecuDePaiement->Remise;

        $total_tva = $total_ht * ($taux / 100);
        $total_Remise = $total_ht * ($Remise / 100);
        $total_ht_avec_remis = $total_ht - $total_Remise;

        $total_ttc = $total_ht - $total_Remise + $total_tva; 
        $total_cents = (int) round($total_ttc * 100);
        $total_words = strtoupper(NumberToWords::transformCurrency('fr', $total_cents, 'MAD'));
        
        $paiements = Paiement::all();
        $delai = $RecuDePaiement->delai . ($RecuDePaiement->type ? " mois": " jours");

        return compact(
            "agence", "numero", "client", "total_ht_avec_remis", "ice", "date", 
            "articles", "total_ht", "tva", "taux", "total_tva", "total_ttc", 
            "total_words", "paiements", "Remise", "total_Remise", "delai", "objet",
            "tel", "adresse", "email", "RecuDePaiement"
        );
    }
}
