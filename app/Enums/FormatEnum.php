<?php

namespace App\Enums;

enum FormatEnum: string
{
    case DOLBY = 'Dolby';
    case SONY = 'Sony';
    case COMBO = 'Combo';

    public static function options(): array
    {
        return [
            self::DOLBY->value,
            self::SONY->value,
            self::COMBO->value,
        ];
    }
}
