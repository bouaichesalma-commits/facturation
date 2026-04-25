<div class="row">
    <div class="col-md-auto" style="margin-bottom: 10px ; ">
        @if (auth()->user()->can('show one bon_commande'))
        <button type="button" wire:click.debounce.200ms="find({{ $bon_commande_id }})" class="btn btn-info" title="Voir"
            style="padding: 3px 9px; font-size: 15px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $bon_commande_id }}">
            <i class="fas fa-eye"></i>
        </button>
        @include('bon_commande.show')
        @endif

        @if (auth()->user()->can('update bon_commande'))
        <div class="d-inline-block">
            <a href="{{ route('bon_commande.edit', $bon_commande_id) }}" class="btn btn-warning" title="Éditer"
                style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif


        @if (auth()->user()->can('create bon_commande'))
        <div class="d-inline-block">
            <form id="duplicateForm{{ $bon_commande_id }}" action="{{ route('bon_commande.duplicate', $bon_commande_id) }}" method="POST" class="d-inline">
                @csrf
                <a href="#" class="btn btn-dark" title="Dupliquer"
                    style="padding: 3px 9px; font-size: 16px;" 
                    onclick="event.preventDefault(); document.getElementById('duplicateForm{{ $bon_commande_id }}').submit();">
                    <i class="fas fa-copy"></i>
                </a>
            </form>
        </div>
        @endif

            
        @if (auth()->user()->can('delete bon_commande'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $bon_commande_id }})" class="btn btn-danger" title="Supprimer"
                style="padding: 3px 9px; font-size: 16px;" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $bon_commande_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('bon_commande.delete')
        </div>
        @endif

        @if (auth()->user()->can('imprimer bon_commande'))
        <div class="d-inline-block">
            <a href="{{ route('bon_commande.download', $bon_commande_id) }}" target="_blank" class="btn btn-success" title="Télécharger"
                style="padding: 3px 9px; font-size: 17px;">
                <i class="fas fa-file-alt"></i>
            </a>
        </div>
        @endif
      
    </div>
</div>
