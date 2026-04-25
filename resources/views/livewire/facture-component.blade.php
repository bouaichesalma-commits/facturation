<div class="row">
    <div class="col-md-auto">
        @if (auth()->user()->can('show one facture'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $facture_id }})" class="btn btn-info" title="Voir"
                style="padding: 3px 9px; font-size: 15px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $facture_id }}">
                <i class="fas fa-eye"></i>
            </button>
            @include('facture.show')
        </div>
        @endif

        @if (auth()->user()->can('update facture'))
        <div class="d-inline-block">
            <a href="{{ route('facture.edit', $facture_id) }}" class="btn btn-warning" title="Modifier"
                style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif
    </div>

    <div class="col-md-auto">
        @if (auth()->user()->can('delete facture'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $facture_id }})" class="btn btn-danger" title="Supprimer"
                style="padding: 3px 9px; font-size: 16px;" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $facture_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('facture.delete')
        </div>
        @endif

        @if (auth()->user()->can('imprimer facture'))
        <div class="d-inline-block">
            <a href="{{ route('facture.download', $facture_id) }}" target="_blank" class="btn btn-success" title="Télécharger"
                style="padding: 3px 9px; font-size: 17px;">
                <i class="fas fa-file-alt"></i>
            </a>
        </div>
        @endif
    </div>
</div>
