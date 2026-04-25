<?php

namespace App\Policies;

use App\Models\BonDeCommande;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BonDeCommandePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('List of all bon_commande') || $user->can('List of all devis');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BonDeCommande $bonDeCommande): bool
    {
        return $user->can('show one bon_commande') || $user->can('show one devis');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create bon_commande') || $user->can('create devis');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BonDeCommande $bonDeCommande): bool
    {
        return $user->can('update bon_commande') || $user->can('update devis');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BonDeCommande $bonDeCommande): bool
    {
        return $user->can('delete bon_commande') || $user->can('delete devis');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BonDeCommande $bonDeCommande): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BonDeCommande $bonDeCommande): bool
    {
        return false;
    }

    /**
     * Determine whether the user can imprimer the model.
     */
    public function imprimer(User $user, BonDeCommande $bonDeCommande): bool
    {
        return $user->can('imprimer bon_commande') || $user->can('imprimer devis');
    }

    /**
     * Determine whether the user can convert the model.
     */
    public function convert(User $user, BonDeCommande $bonDeCommande): bool
    {
        return $user->can('convert bon_commande') || $user->can('convert devis');
    }
}
