
    <div>
    @if (auth()->user()->hasRole('admin'))

        <button type="button" wire:click.debounce.200ms="find({{ $role_id }})" class="dropdown-item dropdown-item-desc edit-btn" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $role_id }}">
            <i class="bi bi-trash3-fill text-danger"></i> Delete
        </button>

    @endif
    </div>