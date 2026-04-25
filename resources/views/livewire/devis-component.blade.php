<div class="row">
    <div class="col-md-auto" style="margin-bottom: 10px ; ">
        @if (auth()->user()->can('show one devis'))
        <button type="button" wire:click.debounce.200ms="find({{ $devis_id }})" class="btn btn-info" title="Voir"
            style="padding: 3px 9px; font-size: 15px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $devis_id }}">
            <i class="fas fa-eye"></i>
        </button>
        @include('devis.show')
        @endif

        @if (auth()->user()->can('update devis'))
        <div class="d-inline-block">
            <a href="{{ route('devis.edit', $devis_id) }}" class="btn btn-warning" title="Éditer"
                style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif


            @if (auth()->user()->can('create devis'))
            <div class="d-inline-block">
                <form id="duplicateForm{{ $devis_id }}" action="{{ route('devis.duplicate', $devis_id) }}" method="POST" class="d-inline">
                    @csrf
                    <a href="#" class="btn btn-dark" title="Dupliquer"
                        style="padding: 3px 9px; font-size: 16px;" 
                        onclick="event.preventDefault(); document.getElementById('duplicateForm{{ $devis_id }}').submit();">
                        <i class="fas fa-copy"></i>
                    </a>
                </form>
            </div>
        @endif

            
        @if (auth()->user()->can('delete devis'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $devis_id }})" class="btn btn-danger" title="Supprimer"
                style="padding: 3px 9px; font-size: 16px;" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $devis_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('devis.delete')
        </div>
        @endif

        @if (auth()->user()->can('imprimer devis'))
        <div class="d-inline-block">
            <a href="{{ route('devis.download', $devis_id) }}" target="_blank" class="btn btn-success" title="Télécharger"
                style="padding: 3px 9px; font-size: 17px;">
                <i class="fas fa-file-alt"></i>
            </a>
        </div>
        @endif
      
    </div>



        @if (auth()->user()->can('convert devis'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $devis_id }})" class="btn btn-secondary" title="Convertir"
                style="padding: 3px 9px; font-size: 16px ;    background-color: #050e85;" data-bs-toggle="modal" data-bs-target="#convertModel{{ $devis_id }}">
                <i class="fas fa-receipt"></i> F
            </button>
            @include('devis.convert')


             <!-- New: Convert to Facture Proforma Button -->
                <button type="button" class="btn btn-info" title="Convertir en Facture Proforma"
                style="padding: 3px 9px; font-size: 16px; margin-left: 5px;" 
                data-bs-toggle="modal" data-bs-target="#convertFP{{ $devis_id }}">
                <i class="fas fa-file-invoice"></i> FP
            </button>
                @include('devis.convert_proforma')


            <!-- Convert to Bon de Livraison Button -->
            <button type="button" class="btn btn-dark" title="Convertir en Bon de Livraison"
                style="padding: 3px 9px; font-size: 16px; margin-left: 5px;     background-color: #ff9500;"
                data-bs-toggle="modal" data-bs-target="#convertBonModel{{ $devis_id }}">
                <i class="fas fa-truck"></i> BL
            </button>

            @include('devis.convert_bon')

             <!-- Convert to Bon de Livraison Button -->
            <button type="button" class="btn " title="Convertir en Bon de Sortie"
                style="padding: 3px 9px; font-size: 16px; margin-left: 5px;     background-color: #b6fc00;"
                data-bs-toggle="modal" data-bs-target="#convertBonSortieModel{{ $devis_id }}">
                <i class="fas fa-truck"></i> BS
            </button>

            @include('devis.convert_sortie')

        </div>
        @endif
    </div>
</div>
