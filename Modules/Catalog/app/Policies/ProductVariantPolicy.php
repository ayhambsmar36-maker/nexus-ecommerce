<?php

namespace Modules\Catalog\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Roles\RoleEnum;
use Modules\Catalog\Models\ProductVariant;

class ProductVariantPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}
    public function viewAny(User $user):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());
    }
    public function view(User $user,ProductVariant $productVariant):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());
    }
    public function create(User $user):bool
    {
        return false;
    }
    public function update(User $user,ProductVariant $productVariant):bool
    {
        return false;
    }
    public function delete(User $user ,ProductVariant $productVariant):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());
    } 
}
