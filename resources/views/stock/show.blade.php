<div class="modal fade" wire:ignore.self id="viewStockModal{{ $stock->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-center">Détails du Stock :</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th>@lang('messages.Designation')</th>
                            <td>{!! $stock->designation == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $stock->designation !!}</td>
                        </tr>
                        
                        <tr>
                            <th>@lang('messages.Détails')</th>
                            <td>{!! $stock->Details == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : ($stock->Details?str_replace("\n", "<br/>", $stock->Details):'Aucun détail') !!}</td>
                        </tr>
                        <tr>
                            <th>Prix de vente</th>
                            <td>{!! $stock->prix == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $stock->prix . ' DH' !!}</td>
                        </tr>
                        <tr>
                            <th>Prix d'achat</th>
                            <td>
                                {!! $stock->prix_achat == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($stock->prix_achat ? $stock->prix_achat . ' DH' : 'Non spécifié') 
                                !!}
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('messages.Quantité')</th>
                            <td>{!! $stock->Quantite == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $stock->Quantite  !!}</td>
                        </tr>
                        <tr>
                            <th>Catégorie</th>
                            <td>{!! $stock->Categorieproduit?->categorie ?? 'Non définie' !!}</td>
                        </tr>
                        <tr>
                            <th>Marque</th>
                            <td>{!! $stock->marque?->nom ?? 'Non définie' !!}</td>
                        </tr>
                        <tr>
                            <th>Fournisseur</th>
                            <td>{!! $stock->fournisseur?->nom ?? 'Non défini' !!}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    @if (auth()->user()->can('update stock'))
                        <a href="{{ route('stock.edit', $stock->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>