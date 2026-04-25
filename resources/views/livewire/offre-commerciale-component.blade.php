<div class="row">
    <div class="col-md-6">
        @if (auth()->user()->can('show one offre commerciale'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $OffreCommerciale_id }})" class="btn text-primary icon-medium-bold" data-bs-toggle="modal" data-bs-target="#viewModal{{ $OffreCommerciale_id }}">
                <i class="bi bi-eye"></i>
            </button>
            @include('OffreCommerciale.show')
        </div>
        @endif
        @if (auth()->user()->can('update offre commerciale'))
        <div class="d-inline-block">
            <a href="{{ route('offreCommerciale.edit', $OffreCommerciale_id) }}"  class="">
                <i class="bi bi-pencil-square text-warning"></i> <!-- Added 'text-warning' class to color the pencil icon -->
            </a>
        </div>
        @endif
    </div>
    <div class="col-md-6">
        @if (auth()->user()->can('delete offre commerciale'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $OffreCommerciale_id }})" class="btn text-danger text-opacity-75" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $OffreCommerciale_id }}">
                <i class="bi bi-trash-fill"></i>
            </button>
            @include('OffreCommerciale.delete')
        </div>
        @endif
        @if (auth()->user()->can('imprimer offre commerciale'))
        <div class="d-inline-block">
            <a href="{{ route('offreCommerciale.download', $OffreCommerciale_id) }}" target="_blank" class="">
                <i class="bi bi-file-earmark-text text-success"></i> <!-- Added 'text-success' class to color the print icon -->
            </a>
        </div>
        @endif
    </div>
</div>
