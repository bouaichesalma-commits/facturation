<?php

namespace App\Http\Controllers;

use App\Http\Requests\OffreCommercialeRequest;
use App\Models\Agence;
use App\Models\Article;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\FactureProforma;
use App\Models\Objectif;
use App\Models\OffreCommerciale;
use App\Models\Paiement;
use App\Models\RecuDePaiement;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;

class OffreCommercialeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', OffreCommerciale::class);
        $OffreCommerciales = OffreCommerciale::all();
        // dd($OffreCommerciales);
        return response()->view('OffreCommerciale.index', compact('OffreCommerciales'));
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', OffreCommerciale::class);
        $articles = Article::all();
        $objectifs = Objectif::distinct()->get();
       
        return response()->view('OffreCommerciale.create', compact('articles','objectifs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OffreCommercialeRequest $request)
    {
        $this->authorize('create', OffreCommerciale::class);
        DB::beginTransaction();
        try {
            $OffreCommerciale = new OffreCommerciale();
            $OffreCommerciale->fill($request->all())->save();

            // this for insert in table OffreCommerciale_article

            $dataProdouits = json_decode($request->input('articles'), true);

            $pivot_info_articles = [];
            $insertion_order =  0;
            foreach($dataProdouits as $keyP){
                $insertion_order++;
                $pivot_info_articles[$keyP["article_id"]] = ["quantity"=>intval($keyP["quantity"]),"insertion_order"=>$insertion_order];
            }
            $OffreCommerciale->articles()->sync($pivot_info_articles);
                

            $objectif = Objectif::firstOrCreate(['text' => $request->objectif]);

            if(empty($objectif)){
                $objectifs = new Objectif();
                $objectifs->text = $request->objectif;
                $objectifs->save();
            }
            
            DB::commit();
            return redirect('/offreCommerciale/create')->with('info', 'The Offre Commerciale added successfully !');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error in OffreCommercialeController@store: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'offre commerciale. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $OffreCommerciale = OffreCommerciale::findOrFail($id);
        $this->authorize('update', $OffreCommerciale);
        $articles = Article::all();
        $objectifs = Objectif::distinct()->get();

        $OffreCommerciale_article = array();
        $pivot_articles = $OffreCommerciale->articles;
        foreach($pivot_articles as $article){
            array_push($OffreCommerciale_article,array("article_id"=> $article->pivot->article_id , "quantity" => $article->pivot->quantity));
        }
        
        return response()->view('OffreCommerciale.edit', compact('OffreCommerciale', 'OffreCommerciale_article','articles','objectifs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OffreCommercialeRequest $request, string $id)
    {
        $OffreCommerciale = OffreCommerciale::findOrFail($id);
        $this->authorize('update', $OffreCommerciale);
        DB::beginTransaction();
        try {
            $OffreCommerciale->fill($request->all())->update();
            

            $dataProdouits = json_decode($request->input('articles'), true);

            $pivot_info_articles = [];
            $insertion_order =  0;
            foreach($dataProdouits as $keyP){
                $insertion_order++;
                $pivot_info_articles[$keyP["article_id"]] = ["quantity"=>intval($keyP["quantity"]),"insertion_order"=>$insertion_order];
            }
            $OffreCommerciale->articles()->sync($pivot_info_articles);
            
            $objectif = Objectif::where('text','=',$request->objectif)->first();
            

            if(empty($objectif)){
                $objectifs = new Objectif();
                $objectifs->text = $request->objectif;
                $objectifs->save();
            }

            DB::commit();
            return redirect('/offreCommerciale/'.$id.'/edit')->with('info', 'The Offre Commerciale updated successfully !');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error in OffreCommercialeController@update: " . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'offre commerciale.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $OffreCommerciale = OffreCommerciale::findOrFail($id);
            $this->authorize('delete', $OffreCommerciale);
            $objectifText = $OffreCommerciale->objectif;
            $OffreCommerciale->delete();
            $objectifExistsInOtherRecords = Facture::where('objectif', $objectifText)->exists() ||
                                            FactureProforma::where('objectif', $objectifText)->exists()||
                                            OffreCommerciale::where('objectif', $objectifText)->exists()||
                                            Devis::where('objectif', $objectifText)->exists()||
                                            RecuDePaiement::where('objectif', $objectifText)->exists();

            if (!$objectifExistsInOtherRecords) {
                Objectif::where('text', $objectifText)->delete();
            }
            return redirect('/offreCommerciale');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in OffreCommercialeController@destroy: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression de l\'offre commerciale.');
        }
    }

    /**
     * Generate the PDF file using native Dompdf (Perfect PDF System)
     */
    public function generatePDF(string $id)
    {
        $data = $this->getOffreData($id);
        
        $html = view('OffreCommerciale.pdf', $data)->render();
        
        $dompdf = new \Dompdf\Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', false); 
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', public_path());
        $dompdf->setOptions($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Offre Commerciale " . $data['numero'];
        return $dompdf->stream($filename . ".pdf", ["Attachment" => true]);
    }

    /**
     * Show the web preview of the document
     */
    public function download($id)
    {
        $data = $this->getOffreData($id);
        return view('OffreCommerciale.download', $data);
    }

    /**
     * Helper to gather all required data for both preview and generation
     */
    private function getOffreData($id)
    {
        $agence = Agence::first();
        $OffreCommerciale = OffreCommerciale::findOrFail($id);

        $objet = $OffreCommerciale->objectif;
        $articles = $OffreCommerciale->articles;
        $total_ht = (float)$OffreCommerciale->montant;
        $numero = $OffreCommerciale->id;
        
        // Add placeholders for consistent mapping
        $client = "Client Potentiel";
        $ice = "";
        $date = date_format(date_create($OffreCommerciale->created_at), 'd / m / Y');

        return compact("agence", "articles", "objet", "total_ht", "numero", "client", "ice", "date", "OffreCommerciale");
    }
}
