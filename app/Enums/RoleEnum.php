<?php
namespace App\Enums;

enum RoleEnum: int
{
    case SUPER_ADMIN = 1;
    case ADMIN = 2;
    case USER = 3;

    /**
     * Obtener el nombre del rol en formato legible.
     */
    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }
}
