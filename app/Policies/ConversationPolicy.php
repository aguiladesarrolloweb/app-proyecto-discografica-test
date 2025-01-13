<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function viewAny(User $user): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $conversation): bool
    {
        if ($this->viewAny($user)) return true;

        $conversation = Conversation::find($conversation);
        
        return in_array($user->id,$conversation->participants->pluck('id')->toArray());
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
    public function update(User $user): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        $roles_admin = [RoleEnum::SUPER_ADMIN->value, RoleEnum::ADMIN->value];
        $roles_user = $user->roles->pluck('id')->toArray();
        
        return !empty(array_intersect($roles_user, $roles_admin));
    }


    public function send(User $user, $conversation): bool
    {

        $conversation = Conversation::find($conversation);

        
        return in_array($user->id,$conversation->participants->pluck('id')->toArray());
    }

}
