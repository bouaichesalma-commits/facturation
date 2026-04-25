<div class="modal fade" wire:ignore.self id="viewModal{{ $Article_id }}" 
     data-bs-backdrop="static" data-bs-keyboard="false" 
     aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-center">Détails du Article :</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th class="w-40">@lang('messages.Designation')</th>
                            <td>
                                {!! $Article['designation'] == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($Article['designation'] ?? '<span class="text-muted">N/A</span>') 
                                !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>@lang('messages.Détails')</th>
                            <td>
                                {!! $Article['Details'] == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($Article['Details'] 
                                        ? str_replace("\n", "<br/>", $Article['Details']) 
                                        : '<span class="text-muted">Aucun détail</span>') 
                                !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Prix de vente</th>
                            <td>
                                {!! $Article['prix'] == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($Article['prix'] 
                                        ? number_format($Article['prix'], 2) . ' MAD' 
                                        : '<span class="text-muted">N/A</span>') 
                                !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Catégorie</th>
                            <td>
                                {!! $Article['designation'] == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($Article->CategorieProduit?->categorie ?? '<span class="text-muted">Non défini</span>') 
                                !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Marque</th>
                            <td>
                                {!! $Article['designation'] == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($Article->Marque?->nom ?? '<span class="text-muted">Non défini</span>') 
                                !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Fournisseur</th>
                            <td>
                                {!! $Article['designation'] == "loading" 
                                    ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" 
                                    : ($Article->Fournisseur?->nom ?? '<span class="text-muted">Non défini</span>') 
                                !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-4 mb-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Fermer
                    </button>
                    
                    @if (auth()->user()->can('update article'))
                    <a href="{{ route('article.edit', $Article_id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square me-1"></i>Modifier
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>