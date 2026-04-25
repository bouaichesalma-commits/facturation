@php
    // Use relationships if available (already eager-loaded in controller)
    $standardArticlesList = $devis->articles->map(function($article) {
        return (object)[
            'produit' => $article->designation,
            'quantite' => $article->pivot->quantity,
            'prix' => $article->pivot->prix
        ];
    });

    $customArticlesList = $devis->customArticles->map(function($custom) {
        return (object)[
            'produit' => $custom->name,
            'quantite' => $custom->quantite,
            'prix' => $custom->prix
        ];
    });

    $devisArticles = $standardArticlesList->concat($customArticlesList);
@endphp


<div class="modal fade"  wire:ignore.self id="viewModal{{ $devis_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Devis Nº {!! $devis['num']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $devis['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $devis['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($devis['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! $devis["client"]['nom'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $devis["client"]['nom'] !!}</td>
                        </tr>
                        
                        <tr>
                            <th>Objectifs</th>
                            <td>{!! $devis["objectif"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $devis["objectif"] !!}</td>
                        </tr>


                        <tr>
                            <th>Produits</th>
                        <td>
                            <ol class="">
                                
                            @foreach (  $devisArticles   as $da)
                            
                            <li class="">{{ $da->produit  }}</li>
                            @endforeach
                        </ol>
                        </td>
                        </tr>
                        
                            <th>Montant</th>
                            <td>{!! $devis["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : number_format($devis["montant"], 2, '.', '') !!} Dh</td>
                        
                   
                       @if ($devis["etatremise"] == "montant")
    <tr>  
        <th>Montant Remise</th>
        <td>{{ number_format($devis["remise"], 2, '.', '') }} Dh</td>
    </tr>
@elseif ($devis["etatremise"] == "pourcentage")
    <tr> 
        <th>Remise</th>
        <td>{{ $devis["remise"] }}%</td>
    </tr>
    <tr>
        <th>Montant Remise</th>
        <td>{{ number_format(($devis["remise"] / 100) * $devis["montant"], 2, '.', '') }} Dh</td>
    </tr>
@endif

@if ($devis["tva"] === 'on' || $devis["tva"] == 1)
    <tr>
        <th>TVA</th>
        <td>{{ $devis["taux"] }} %</td>
    </tr>
    <tr>
        <th>Montant TVA</th>
        <td>
            @if ($devis["etatremise"] == "pourcentage")
                {{ number_format(($devis["taux"] / 100) * ($devis["montant"] - ($devis["remise"] / 100) * $devis["montant"]), 2, '.', '') }} Dh
            @elseif ($devis["etatremise"] == "montant")
                {{ number_format(($devis["taux"] / 100) * ($devis["montant"] - $devis["remise"]), 2, '.', '') }} Dh
            @else
                {{ number_format(($devis["taux"] / 100) * $devis["montant"], 2, '.', '') }} Dh
            @endif
        </td>
    </tr>
@else
    <tr>
        <th>TVA</th>
        <td>Non inclus</td>
    </tr>
@endif

<tr>
    <th>Montant TTC</th>
    <td>
        @php
            $montant = (float)$devis["montant"];
            $remiseValue = (float)$devis["remise"];
            $tauxTva = ($devis["tva"] === 'on' || $devis["tva"] == 1) ? ((float)$devis["taux"] / 100) : 0;
            
            $base = $montant;
            if ($devis["etatremise"] == "pourcentage") {
                $base = $montant - ($remiseValue / 100 * $montant);
            } elseif ($devis["etatremise"] == "montant") {
                $base = $montant - $remiseValue;
            }
            
            $totalTtc = $base + ($base * $tauxTva);
        @endphp

        {{ number_format($totalTtc, 2, '.', '') }} Dh
    </td>
</tr>

                        
                    {{-- ==================================================================== --}}
                  

                        <tr>
                            <th>Etat</th>
                            <td>{!! $devis["etat"] ?  "<span class='badge rounded-pill badge-bg-primary'>Validé</span>" : "<span class='badge rounded-pill badge-bg-warning'>Non validé</span>" !!}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    @if (auth()->user()->can('update devis'))
                
                    <a href="{{ route('devis.edit', $devis_id) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                    @endif

                    @if (auth()->user()->can('imprimer devis'))
                    <a href="{{ route('devis.download', $devis_id) }}" target="_blink" class="btn btn-facture">
                        <i class="bi bi-file-earmark-text"></i> Imprimer
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
