<?php

namespace Modules\Catalog\Policies;
use App\Models\User;
use App\Roles\RoleEnum;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Catalog\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());
    }
    public function view(User $user,Product $product):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());
    }
    public function create(User $user):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());  
    }
    public function update(User $user,Product $product):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());
    }
    public function delete(User $user ,Product $product):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());  
    }
  
}
