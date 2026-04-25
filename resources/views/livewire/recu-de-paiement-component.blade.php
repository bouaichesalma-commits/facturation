<div class="row">
    <div class="col-md-6">
        @if (auth()->user()->can('show one recu de paiement'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $RecuDePaiement_id }})" class="btn text-primary icon-medium-bold" data-bs-toggle="modal" data-bs-target="#viewModal{{ $RecuDePaiement_id }}">
                <i class="bi bi-eye"></i>
            </button>
            @include('RecuDePaiement.show')
        </div>
        @endif

        @if (auth()->user()->can('update recu de paiement'))
        <div class="d-inline-block">
            <a href="{{ route('RecuDePaiement.edit', $RecuDePaiement_id) }}" class="">
                <i class="bi bi-pencil-square text-warning"></i> <!-- Added 'text-warning' class to color the pencil icon -->
            </a>
        </div>
        @endif
    </div>
    <div class="col-md-6">
        @if (auth()->user()->can('delete recu de paiement'))
        <div class="d-inline-block">

            <button type="button" wire:click.debounce.200ms="find({{ $RecuDePaiement_id }})" class="btn text-danger text-opacity-75" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $RecuDePaiement_id }}">
                <i class="bi bi-trash-fill"></i>
            </button>
            @include('RecuDePaiement.delete')
        </div>
        @endif

        @if (auth()->user()->can('imprimer recu de paiement'))
        <div class="d-inline-block">
            <a href="{{ route('RecuDePaiement.download', $RecuDePaiement_id) }}"  target="_blank" class="">
                <i class="bi bi-file-earmark-text text-success"></i> <!-- Added 'text-success' class to color the print icon -->
            </a>
        </div>
        @endif
    </div>
</div>
