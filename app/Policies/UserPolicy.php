<?php

namespace App\Policies;

use App\Models\User;
use App\Roles\RoleEnum;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(RoleEnum::owner());
    }
    public function view(User $user, User $model): bool
    {
        return $user->hasAnyRole(RoleEnum::owner());
    }
    public function create(User $user): bool
    {
        return $user->hasAnyRole(RoleEnum::owner());        

    }
    public function update(User $user, User $model): bool
    {
        return $user->hasAnyRole(RoleEnum::owner());
    }
    public function delete(User $user, User $model): bool
    {
        return $user->hasAnyRole(RoleEnum::owner());
    }

}
