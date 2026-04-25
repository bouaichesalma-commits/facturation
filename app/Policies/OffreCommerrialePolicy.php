<?php

namespace App\Policies;

use App\Models\OffreCommerciale;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OffreCommerrialePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        
        return $user->can('List of all offre commerciale');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OffreCommerciale $offreCommerciale): bool
    {
        
        return $user->can('show one offre commerciale');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
        return $user->can('create offre commerciale');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OffreCommerciale $offreCommerciale): bool
    {
        
        return $user->can('update offre commerciale');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OffreCommerciale $offreCommerciale): bool
    {
        
        return $user->can('delete offre commerciale');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OffreCommerciale $offreCommerciale): bool
    {
        
        return false ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OffreCommerciale $offreCommerciale): bool
    {
        
        return false ;
    }
    /**
     * Determine whether the user can imprimer the model.
     */
    public function imprimer(User $user, OffreCommerciale $offreCommerciale): bool
    {
        
        return $user->can('imprimer offre commerciale');
    }
}
