<div class="row">
    <div class="col-md-auto">
        @if (auth()->user()->can('show one client'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $client_id }})" class="btn btn-info" title="Voir" style="padding: 3px 9px; font-size: 15px;" data-bs-toggle="modal" data-bs-target="#viewModal{{ $client_id }}">
                <i class="fas fa-eye"></i>
            </button>
            @include('client.show')
        </div>
        @endif

        @if (auth()->user()->can('update client'))
        <div class="d-inline-block">
            <a href="{{ route('client.edit', $client_id) }}" class="btn btn-warning" title="Éditer" style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif
        @if (auth()->user()->can('delete client'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $client_id }})" class="btn btn-danger" title="Supprimer" style="padding: 3px 9px; font-size: 16px;" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $client_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('client.delete')
        </div>
        @endif
 
    </div>
</div>
