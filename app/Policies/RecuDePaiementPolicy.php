<?php

namespace App\Policies;

use App\Models\RecuDePaiement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecuDePaiementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        
        return $user->can('List of all recu de paiement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RecuDePaiement $recuDePaiement): bool
    {
        
        return $user->can('show one recu de paiement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
        return $user->can('create recu de paiement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RecuDePaiement $recuDePaiement): bool
    {
        
        return $user->can('update recu de paiement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RecuDePaiement $recuDePaiement): bool
    {
        
        return $user->can('delete recu de paiement');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RecuDePaiement $recuDePaiement): bool
    {
        
        return false ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RecuDePaiement $recuDePaiement): bool
    {
        
        return false ;
    }
    /**
     * Determine whether the user can imprimer the model.
     */
    public function imprimer(User $user, RecuDePaiement $recuDePaiement): bool
    {
        
        return $user->can('imprimer recu de paiement');
    }
}
