<div class="row">
    <div class="col-md-auto">
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $stock_id }})"
                class="btn btn-info" title="Voir" style="padding: 3px 9px; font-size: 15px;"
                data-bs-toggle="modal" data-bs-target="#viewStockModal{{ $stock_id }}">
                <i class="fas fa-eye"></i>
            </button>
            @include('stock.show')
        </div>

        @if (auth()->user()->can('update stock'))
        <div class="d-inline-block">
            <a href="{{ route('stock.edit', $stock_id) }}" class="btn btn-warning" title="Éditer" style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif
    </div>

    <div class="col-md-auto">
        @if (auth()->user()->can('delete stock'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $stock_id }})"
                class="btn btn-danger" title="Supprimer" style="padding: 3px 9px; font-size: 16px;"
                data-bs-toggle="modal" data-bs-target="#deleteStockModal{{ $stock_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('stock.delete')
        </div>
        @endif
    </div>
</div>