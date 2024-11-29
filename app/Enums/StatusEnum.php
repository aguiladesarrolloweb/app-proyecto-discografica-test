<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';

    public static function options(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
            self::PENDING->value,
        ];
    }
}
