<?php

namespace Modules\Catalog\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Roles\RoleEnum; 
use Modules\Catalog\Models\ProductAttribute;
class ProductAttributePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}
    public function viewAny(User $user):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());
    }   
    public function view(User $user,ProductAttribute $productAttribute):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());
    }   
    public function create(User $user):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());
    }
    public function update(User $user,ProductAttribute $productAttribute):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());  
    }
    public function delete(User $user ,ProductAttribute $productAttribute):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());  
    }
}
