<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Package;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PackagePolicy
{


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Package $package): bool
    {
        if ($this->viewAny($user)) return true;
        
        return in_array($user->id,$package->users->pluck('id')->toArray());
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
    public function update(User $user, Package $package): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Package $package): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Package $package): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Package $package): bool
    {
        return true;
    }

    
    public function createTrack(User $user, Package $package): bool
    {
        if ($this->viewAny($user)) return true;
        
        return in_array($user->id,$package->users->pluck('id')->toArray());
    }
}
