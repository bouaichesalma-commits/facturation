<?php

namespace App\Policies;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('List of all article');
    }

    public function view(User $user, Stock $stock): bool
    {
        return $user->can('show one article');
    }

    public function create(User $user): bool
    {
        return $user->can('create article');
    }

    public function update(User $user, Stock $stock): bool
    {
        return $user->can('update article');
    }

    public function delete(User $user, Stock $stock): bool
    {
        return $user->can('delete article');
    }

    public function restore(User $user, Stock $stock): bool
    {
        return true; // Or define proper logic
    }

    public function forceDelete(User $user, Stock $stock): bool
    {
        return true; // Or define proper logic
    }
}
