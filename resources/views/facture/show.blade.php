@php
      $factureArticles = [];
    
    // Get standard articles
    $standardArticles = DB::table('facture_article')
        ->where('facture_id', $facture['id'])
        ->join('articles', 'facture_article.article_id', '=', 'articles.id')
        ->select('articles.id', 'articles.designation as produit', 'facture_article.quantity as quantite', 'articles.prix')
        ->get()
        ->toArray();
    
    // Get custom articles
    $customArticles = DB::table('custom_facture_articles')
        ->where('facture_id', $facture['id'])
        ->select('name as produit', 'custom_facture_articles.quantite as quantite', 'prix')
        ->get()
        ->toArray();
    
    // Combine both types of articles
    $factureArticles = array_merge($standardArticles, $customArticles);
@endphp

<div class="modal fade"  wire:ignore.self id="viewModal{{ $facture_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Facture Nº {!! $facture['num'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $facture['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $facture['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($facture['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! $facture['client']["nom"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $facture['client']["nom"] !!}</td>
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
                            <td>{!! $facture["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : number_format($facture["montant"], 2, '.', '') !!} Dh</td>
                        </tr>
                             
                    {{-- =========================================================================== --}}
                
              @if ($facture["etatremise"] == "montant")
    <tr>  
        <th>Montant Remise</th>
        <td>{{ number_format($facture["remise"], 2, '.', '') }} Dh</td>
    </tr>
@elseif ($facture["etatremise"] == "pourcentage")
    <tr> 
        <th>Remise</th>
        <td>{{ $facture["remise"] }}%</td>
    </tr>
    <tr>
        <th>Montant Remise</th>
        <td>{{ number_format(($facture["remise"] / 100) * $facture["montant"], 2, '.', '') }} Dh</td>
    </tr>
@endif

@if($facture["tva"])
<tr>
    <th>TVA</th>
    <td>20 %</td>
</tr>
<tr>
    <th>Montant TVA</th>
    <td>
        @if ($facture["etatremise"] == "pourcentage")
            {{ number_format((20 / 100) * ($facture["montant"] - ($facture["remise"] / 100) * $facture["montant"]), 2, '.', '') }} Dh
        @elseif ($facture["etatremise"] == "montant")
            {{ number_format((20 / 100) * ($facture["montant"] - $facture["remise"]), 2, '.', '') }} Dh
        @else
            {{ number_format((20 / 100) * $facture["montant"], 2, '.', '') }} Dh
        @endif
    </td>
</tr>
@endif

<tr>
    <th>Montant TTC</th>
    <td>
        @php
            $tvaFactor = $facture["tva"] ? 0.2 : 0;
            $montant = (float)$facture["montant"];
            $remise = (float)$facture["remise"];
            $ttc = 0;
            if ($facture["etatremise"] == "pourcentage") {
                $base = $montant - ($remise / 100 * $montant);
                $ttc = $base + ($base * $tvaFactor);
            } elseif ($facture["etatremise"] == "montant") {
                $base = $montant - $remise;
                $ttc = $base + ($base * $tvaFactor);
            } else {
                $ttc = $montant + ($montant * $tvaFactor);
            }
        @endphp
        {{ number_format($ttc, 2, '.', '') }} Dh
    </td>
</tr>

    {{-- ==================================================================== --}}
                    
                       

                        <tr>
                            <th>Etat</th>
                            <td>{!! $facture["etat"] ? "<span class='badge rounded-pill badge-bg-primary'>Payée</span>": "<span class='badge rounded-pill badge-bg-warning'>Impayée</span>"!!}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
