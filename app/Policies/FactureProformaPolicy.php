<?php

namespace App\Policies;

use App\Models\FactureProforma;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FactureProformaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        
        return $user->can('List of all facture proformas');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FactureProforma $factureProforma): bool
    {
        
        return $user->can('show one facture proformas');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
        return $user->can('create facture proformas');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FactureProforma $factureProforma): bool
    {
        
        return $user->can('update facture proformas');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FactureProforma $factureProforma): bool
    {
        
        return $user->can('delete facture proformas');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FactureProforma $factureProforma): bool
    {
        
        return false ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FactureProforma $factureProforma): bool
    {
        
        return false ;
    }
    /**
     * Determine whether the user can imprimer the model.
     */
    public function imprimer(User $user, FactureProforma $factureProforma): bool
    {
        
        return $user->can('imprimer facture proformas');
    }
}
