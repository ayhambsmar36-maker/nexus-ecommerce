<?php

namespace Modules\Catalog\Policies;
use App\Models\User;
use App\Roles\RoleEnum; 
use Modules\Catalog\Models\Inventory;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryPolicy
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
    public function view(User $user,Inventory $inventory):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());
    }
    public function create(User $user):bool
    {
        return $user->hasAnyRole(RoleEnum::allRoles());      

    }
    public function update(User $user,Inventory $inventory):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());
    }
    public function delete(User $user ,Inventory $inventory):bool
    {
        return $user->hasAnyRole(RoleEnum::managementRoles());
    }
    
}
