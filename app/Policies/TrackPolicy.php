<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Track;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrackPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Track $track): bool
    {
        if ($this->create($user)) return true;
        
        return (int) $user->id === (int) $track->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Track $track): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Track $track): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Track $track): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Track $track): bool
    {
        //
    }
}
