<div class="row">
    <div class="col-md-auto">
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $Article_id }})"
                class="btn btn-info" title="Voir" style="padding: 3px 9px; font-size: 15px;"
                data-bs-toggle="modal" data-bs-target="#viewModal{{ $Article_id }}">
                <i class="fas fa-eye"></i>
            </button>
            @include('Article.show')
        </div>

        @if (auth()->user()->can('update article'))
        <div class="d-inline-block">
            <a href="{{ route('article.edit', $Article_id) }}" class="btn btn-warning" title="Éditer" style="padding: 3px 9px; font-size: 16px;">
                <i class="fas fa-edit"></i>
            </a>
        </div>
        @endif

 
    </div>

    <div class="col-md-auto">
        @if (auth()->user()->can('delete article'))
        <div class="d-inline-block">
            <button type="button" wire:click.debounce.200ms="find({{ $Article_id }})"
                class="btn btn-danger" title="Supprimer" style="padding: 3px 9px; font-size: 16px;"
                data-bs-toggle="modal" data-bs-target="#deleteModel{{ $Article_id }}">
                <i class="fas fa-trash"></i>
            </button>
            @include('Article.delete')
        </div>
        @endif
    </div>
</div>
