<div class="modal fade"  wire:ignore.self id="viewModal{{ $OffreCommerciale_id }}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Offre Commerciales Nº {!! $OffreCommerciale['num']  == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $OffreCommerciale['num'] !!}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-striped">
                    <tbody>
                        
                        <tr>
                            <th>Objectifs</th>
                            <td>{!! $OffreCommerciale["objectif"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $OffreCommerciale["objectif"] !!}</td>
                        </tr>


                        <tr>
                            <th>Produits</th>
                        <td>
                            <ol class="">
                                
                            @foreach ($OffreCommerciale_article  as $da)
                            
                            <li class=" ">
                                {!! $da["designation"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $da["designation"] !!}</li>
                            @endforeach
                        </ol>
                        </td>
                        </tr>
                        <tr>
                            <th>Montant</th>
                            <td>{!! $OffreCommerciale["montant"] == "loading" ? "<div class='spinner-border spinner-border-sm text-secondary' role='status'><span class='visually-hidden'>Loading...</span></div>" : $OffreCommerciale["montant"] !!} Dh</td>
                        </tr>
                    
                            
                    </tbody>
                </table>

                <div class="text-center d-flex flex-md-row flex-column justify-content-center flex-wrap gap-2 mt-5 mb-2">
                    <button type="button" class="btn btn-secondary order-last order-md-first" data-bs-dismiss="modal">
                        <i class="bi bi-caret-left-fill"></i> Fermer
                    </button>
                    @if (auth()->user()->can('update offre commerciale'))
                    <a href="{{ route('offreCommerciale.edit', $OffreCommerciale_id) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                    @endif
                    @if (auth()->user()->can('imprimer offre commerciale'))
                    <a href="{{ route('offreCommerciale.download', $OffreCommerciale_id) }}" target="_blink" class="btn btn-facture">
                        <i class="bi bi-file-earmark-text"></i> Imprimer
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
