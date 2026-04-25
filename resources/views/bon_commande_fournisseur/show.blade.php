@php
    // Use already eager-loaded relationships
    $bonCommandeArticles = $bon_commande_fournisseur->articles->map(function($item) {
        return (object)[
            'produit' => $item->article ? $item->article->designation : $item->produit,
            'quantite' => $item->quantite,
            'prix' => $item->prix
        ];
    });
@endphp

<div class="modal fade" wire:ignore.self id="viewModal{{ $bon_commande_fournisseur_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Bon de Commande Fournisseur Nº {!! $bon_commande_fournisseur['num'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $bon_commande_fournisseur['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{!! $bon_commande_fournisseur['date'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : date_format(date_create($bon_commande_fournisseur['date']), 'd / m / Y') !!}</td>
                        </tr>
                        <tr>
                            <th>Fournisseur</th>
                            <td>{!! isset($bon_commande_fournisseur["fournisseur"]) && $bon_commande_fournisseur["fournisseur"]['nom'] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : (isset($bon_commande_fournisseur["fournisseur"]) ? $bon_commande_fournisseur["fournisseur"]['nom'] : '') !!}</td>
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
                            <td>{!! $bon_commande_fournisseur["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : number_format($bon_commande_fournisseur["montant"], 2, '.', '') !!} Dh</td>
                        </tr>
                   
                        @if ($bon_commande_fournisseur["etatremise"] == "montant")
                            <tr>  
                                <th>Montant Remise</th>
                                <td>{{ number_format($bon_commande_fournisseur["remise"], 2, '.', '') }} Dh</td>
                            </tr>
                        @elseif ($bon_commande_fournisseur["etatremise"] == "pourcentage")
                            <tr> 
                                <th>Remise</th>
                                <td>{{ number_format($bon_commande_fournisseur["remise"], 2, '.', '') }}%</td>
                            </tr>
                            <tr>
                                <th>Montant Remise</th>
                                <td>{{ number_format(($bon_commande_fournisseur["remise"] / 100) * $bon_commande_fournisseur["montant"], 2, '.', '') }} Dh</td>
                            </tr>
                        @endif

                        @if ($bon_commande_fournisseur["tva"] === '1' || $bon_commande_fournisseur["tva"] == 1 || $bon_commande_fournisseur["tva"] === 'on')
                            <tr>
                                <th>TVA</th>
                                <td>{{ $bon_commande_fournisseur["taux"] }} %</td>
                            </tr>
                            <tr>
                                <th>Montant TVA</th>
                                <td>
                                    @if ($bon_commande_fournisseur["etatremise"] == "pourcentage")
                                        {{ number_format(($bon_commande_fournisseur["taux"] / 100) * ($bon_commande_fournisseur["montant"] - ($bon_commande_fournisseur["remise"] / 100) * $bon_commande_fournisseur["montant"]), 2, '.', '') }} Dh
                                    @elseif ($bon_commande_fournisseur["etatremise"] == "montant")
                                        {{ number_format(($bon_commande_fournisseur["taux"] / 100) * ($bon_commande_fournisseur["montant"] - $bon_commande_fournisseur["remise"]), 2, '.', '') }} Dh
                                    @else
                                        {{ number_format(($bon_commande_fournisseur["taux"] / 100) * $bon_commande_fournisseur["montant"], 2, '.', '') }} Dh
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
                                    $montant = (float)$bon_commande_fournisseur["montant"];
                                    $remiseValue = (float)$bon_commande_fournisseur["remise"];
                                    $tauxTva = ($bon_commande_fournisseur["tva"] === '1' || $bon_commande_fournisseur["tva"] == 1 || $bon_commande_fournisseur["tva"] === 'on') ? ((float)$bon_commande_fournisseur["taux"] / 100) : 0;
                                    
                                    $base = $montant;
                                    if ($bon_commande_fournisseur["etatremise"] == "pourcentage") {
                                        $base = $montant - ($remiseValue / 100 * $montant);
                                    } elseif ($bon_commande_fournisseur["etatremise"] == "montant") {
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
                        <a href="{{ route('bon_commande_fournisseur.edit', $bon_commande_fournisseur_id) }}" class="btn btn-edit">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                    @endif

                    @if (auth()->user()->can('imprimer bon_commande'))
                        <a href="{{ route('bon_commande_fournisseur.download', $bon_commande_fournisseur_id) }}" target="_blank" class="btn btn-facture">
                            <i class="bi bi-file-earmark-text"></i> Imprimer
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
