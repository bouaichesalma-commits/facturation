<div class="row">
    <div class="col-md-auto">
        @if (auth()->user()->can('show one facture proformas'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $factureProforma_id }})" class="btn btn-info" title="Voir"
                style="padding: 3px 9px; font-size: 15px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $factureProforma_id }}">
                <i class="fas fa-eye"></i>
            </button>
            @include('FactureProforma.show')
        </div>
        @endif

        @if (auth()->user()->can('update facture proformas'))
        <div class="d-inline-block">
             <a href="{{ route('factureProforma.edit', $factureProforma_id) }}"  class="btn btn-warning" title="Modifier"
                style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif
    </div>

    <div class="col-md-auto">
        @if (auth()->user()->can('delete facture proformas'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $factureProforma_id }})" class="btn btn-danger" title="Supprimer"
                style="padding: 3px 9px; font-size: 16px;" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $factureProforma_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('FactureProforma.delete')
        </div>
        @endif

        @if (auth()->user()->can('imprimer facture proformas'))
        <div class="d-inline-block">
            <a href="{{ route('factureProforma.download', $factureProforma_id) }}" target="_blank" class="btn btn-success" title="Télécharger"
                style="padding: 3px 9px; font-size: 17px;">
                <i class="fas fa-file-alt"></i>
            </a>
        </div>
        @endif
    </div>
</div>
