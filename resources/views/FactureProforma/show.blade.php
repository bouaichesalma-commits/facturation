@php
      $factureArticles = [];
    
     $standardArticles = DB::table('facture_proforma_articles')
        ->where('facture_proforma_id', $factureProforma['id'])
        ->join('articles', 'facture_proforma_articles.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'facture_proforma_articles.quantity as quantite', 'facture_proforma_articles.prix')
        ->get()
        ->toArray();
    
    $customArticles = DB::table('custom_product_facture_proforma')
        ->where('facture_proforma_id', $factureProforma['id'])
        ->select(DB::raw('NULL as id'), 'name as produit', 'quantity as quantite', 'prix')
        ->get()
        ->toArray();
    
    $factureArticles = array_merge($standardArticles, $customArticles);
@endphp


<div class="modal fade"  wire:ignore.self id="viewModal{{ $factureProforma_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Facture Nº {!! $factureProforma['num'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $factureProforma['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $factureProforma['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($factureProforma['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! $factureProforma['client']["nom"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $factureProforma['client']["nom"] !!}</td>
                        </tr>
                            
                      

                        <tr>
                            <th>Produits</th>
                            <td>
                                <ul>
                               
                                    @foreach ($factureArticles as $fa)
                                        
                                        <li class="">{{ $fa->produit  }}</li>
                                        
                                    @endforeach
                                
                                  
                                  </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>Montant HT</th>
                            <td>{!! $factureProforma["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : number_format($factureProforma["montant"], 2, '.', '') !!} Dh</td>
                        </tr>
                           
                             
                                    {{-- =========================================================================== --}}
                                
                              @if ($factureProforma["etatremise"] == "montant")
    <tr>  
        <th>Montant Remise</th>
        <td>{{ number_format($factureProforma["remise"], 2, '.', '') }} Dh</td>
    </tr>
@elseif ($factureProforma["etatremise"] == "pourcentage")
    <tr> 
        <th>Remise</th>
        <td>{{ $factureProforma["remise"] }}%</td>
    </tr>
    <tr>
        <th>Montant Remise</th>
        <td>{{ number_format(($factureProforma["remise"] / 100) * $factureProforma["montant"], 2, '.', '') }} Dh</td>
    </tr>
@endif

@if($factureProforma["tva"])
<tr>
    <th>TVA</th>
    <td>{{ $factureProforma["tva"] }} %</td>
</tr>
<tr>
    <th>Montant TVA</th>
    <td>
        @if ($factureProforma["etatremise"] == "pourcentage")
            {{ number_format(($factureProforma["tva"] / 100) * ($factureProforma["montant"] - ($factureProforma["remise"] / 100) * $factureProforma["montant"]), 2, '.', '') }} Dh
        @elseif ($factureProforma["etatremise"] == "montant")
            {{ number_format(($factureProforma["tva"] / 100) * ($factureProforma["montant"] - $factureProforma["remise"]), 2, '.', '') }} Dh
        @else
            {{ number_format(($factureProforma["tva"] / 100) * $factureProforma["montant"], 2, '.', '') }} Dh
        @endif
    </td>
</tr>
@endif

<tr>
    <th>Montant TTC</th>
    <td>
        @php
            $tvaNum = (float)$factureProforma["tva"];
            $tvaFactor = $tvaNum / 100;
            $montant = (float)$factureProforma["montant"];
            $remise = (float)$factureProforma["remise"];
            $ttc = 0;
            
            $base = $montant;
            if ($factureProforma["etatremise"] == "pourcentage") {
                $base = $montant - ($remise / 100 * $montant);
            } elseif ($factureProforma["etatremise"] == "montant") {
                $base = $montant - $remise;
            }
            
            $ttc = $base + ($base * $tvaFactor);
        @endphp
        {{ number_format($ttc, 2, '.', '') }} Dh
    </td>
</tr>


                {{-- ==================================================================== --}}
                       

                        <tr>
                            <th>Etat</th>
                            <td>{!! $factureProforma["etat"] ? "<span class='badge rounded-pill badge-bg-primary'>Payée</span>": "<span class='badge rounded-pill badge-bg-warning'>Impayée</span>"!!}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    @if (auth()->user()->can('update facture proformas'))
                    <a href="{{ route('factureProforma.edit', $factureProforma_id) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                        
                    @endif
                    @if (auth()->user()->can('imprimer facture proformas'))
                    <a href="{{ route('factureProforma.download', $factureProforma_id) }}" target="_blink" class="btn btn-facture">
                        <i class="bi bi-file-earmark-text"></i> Imprimer
                    </a>
                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
