<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model)
    {
        // Admin can view anyone, regular users can only view themselves
        return $user->role === 'admin' || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model)
    {
        // Admin can update anyone except admin_inti
        if ($user->role === 'admin') {
            return $model->role !== 'admin_inti';
        }
        
        // Users can update themselves
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model)
    {
        // Prevent users from deleting themselves
        if ($user->id === $model->id) {
            return false;
        }
        
        // Admin can delete anyone except admin_inti
        if ($user->role === 'admin') {
            return $model->role !== 'admin_inti';
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->role === 'admin' && $model->role !== 'admin_inti';
    }
}
