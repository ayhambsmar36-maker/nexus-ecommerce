<?php

namespace App\Roles;

enum RoleEnum :string
{
    case Admin='Admin';
    case Staff='Staff';
    case SuperAdmin='SuperAdmin';
    
    public static function allRoles(): array
    {
        return [
            self::Admin->value,
            self::Staff->value,
            self::SuperAdmin->value,
        ];
    }
    public static function managementRoles(): array
    {
        return [
            self::Admin->value,
            self::SuperAdmin->value,
        ];
    }
    public static function owner() : array
    {
        return [
            self::SuperAdmin->value,
        ];

    }
}
