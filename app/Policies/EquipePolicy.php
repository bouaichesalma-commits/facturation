<?php

namespace App\Policies;

use App\Models\equipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        
        return $user->can('List of all equipe');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, equipe $equipe): bool
    {
        
        return $user->can('show one equipe');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
        return $user->can('create one equipe');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, equipe $equipes): bool
    {
        
        return $user->can('update equipe');
    }
   

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, equipe $equipes): bool
    {
        
        return $user->can('delete equipe');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equipe $equipes): bool
    {
        
        return false ;
    }
    

    /**
     * Determine whether the user can permanently delete the model.
     */
    
}
