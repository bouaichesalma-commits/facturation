@php
    // Use already eager-loaded relationships
    $bonCommandeArticles = $bon_commande->articles->map(function($item) {
        return (object)[
            'produit' => $item->article ? $item->article->designation : $item->produit,
            'quantite' => $item->quantite,
            'prix' => $item->prix
        ];
    });
@endphp

<div class="modal fade" wire:ignore.self id="viewModal{{ $bon_commande_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Bon de commande Nº {!! $bon_commande['num'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $bon_commande['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $bon_commande['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($bon_commande['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! isset($bon_commande["client"]) && $bon_commande["client"]['nom'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : (isset($bon_commande["client"]) ? $bon_commande["client"]['nom'] : '') !!}</td>
                        </tr>

                        <tr>
                            <th>Produits</th>
                            <td>
                                <ol class="">
                                    @foreach ($bonCommandeArticles as $da)
                                        <li class="">{{ $da->produit }}</li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Montant</th>
                            <td>{!! $bon_commande["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : number_format($bon_commande["montant"], 2, '.', '') !!} Dh</td>
                        </tr>
                   
                        @if ($bon_commande["etatremise"] == "montant")
                            <tr>  
                                <th>Montant Remise</th>
                                <td>{{ number_format($bon_commande["remise"], 2, '.', '') }} Dh</td>
                            </tr>
                        @elseif ($bon_commande["etatremise"] == "pourcentage")
                            <tr> 
                                <th>Remise</th>
                                <td>{{ number_format($bon_commande["remise"], 2, '.', '') }}%</td>
                            </tr>
                            <tr>
                                <th>Montant Remise</th>
                                <td>{{ number_format(($bon_commande["remise"] / 100) * $bon_commande["montant"], 2, '.', '') }} Dh</td>
                            </tr>
                        @endif

                        @if ($bon_commande["tva"] === '1' || $bon_commande["tva"] == 1 || $bon_commande["tva"] === 'on')
                            <tr>
                                <th>TVA</th>
                                <td>{{ $bon_commande["taux"] }} %</td>
                            </tr>
                            <tr>
                                <th>Montant TVA</th>
                                <td>
                                    @if ($bon_commande["etatremise"] == "pourcentage")
                                        {{ number_format(($bon_commande["taux"] / 100) * ($bon_commande["montant"] - ($bon_commande["remise"] / 100) * $bon_commande["montant"]), 2, '.', '') }} Dh
                                    @elseif ($bon_commande["etatremise"] == "montant")
                                        {{ number_format(($bon_commande["taux"] / 100) * ($bon_commande["montant"] - $bon_commande["remise"]), 2, '.', '') }} Dh
                                    @else
                                        {{ number_format(($bon_commande["taux"] / 100) * $bon_commande["montant"], 2, '.', '') }} Dh
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
                                    $montant = (float)$bon_commande["montant"];
                                    $remiseValue = (float)$bon_commande["remise"];
                                    $tauxTva = ($bon_commande["tva"] === '1' || $bon_commande["tva"] == 1 || $bon_commande["tva"] === 'on') ? ((float)$bon_commande["taux"] / 100) : 0;
                                    
                                    $base = $montant;
                                    if ($bon_commande["etatremise"] == "pourcentage") {
                                        $base = $montant - ($remiseValue / 100 * $montant);
                                    } elseif ($bon_commande["etatremise"] == "montant") {
                                        $base = $montant - $remiseValue;
                                    }
                                    
                                    $totalTtc = $base + ($base * $tauxTva);
                                @endphp
                                {{ number_format($totalTtc, 2, '.', '') }} Dh
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    @if (auth()->user()->can('update bon_commande'))
                        <a href="{{ route('bon_commande.edit', $bon_commande_id) }}" class="btn btn-edit">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                    @endif

                    @if (auth()->user()->can('imprimer bon_commande'))
                        <a href="{{ route('bon_commande.download', $bon_commande_id) }}" target="_blank" class="btn btn-facture">
                            <i class="bi bi-file-earmark-text"></i> Imprimer
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
