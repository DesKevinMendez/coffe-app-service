<?php

namespace App\Policies;

use App\Models\SpatiePermissions;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpatiePermissionsPolicy
{
    use HandlesAuthorization;

    /**
    * Perform pre-authorization checks.
    *
    * @param  \App\Models\User  $user
    * @param  string  $ability
    * @return void|bool
    */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin') || $user->hasRole('superadmin')) return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SpatiePermissions  $spatiePermissions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SpatiePermissions $spatiePermissions)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SpatiePermissions  $spatiePermissions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SpatiePermissions $spatiePermissions)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SpatiePermissions  $spatiePermissions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SpatiePermissions $spatiePermissions)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SpatiePermissions  $spatiePermissions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SpatiePermissions $spatiePermissions)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SpatiePermissions  $spatiePermissions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SpatiePermissions $spatiePermissions)
    {
        //
    }
}
