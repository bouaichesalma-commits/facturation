
<div>
    @if (auth()->user()->can('delete user'))

    <button type="button" wire:click.debounce.200ms="find({{ $user_id }})" class="dropdown-item dropdown-item-desc edit-btn" data-bs-toggle="modal" data-bs-target="#deleteModel{{ $user_id }}">
        <i class="bi bi-trash3-fill text-danger"></i> Delete
    </button>
    @endif
</div>
