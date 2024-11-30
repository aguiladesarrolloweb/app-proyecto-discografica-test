<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case SINGER = 'singer';
    case BAND = 'band';
    case PRODUCER = 'producer';
    case OTHER = 'other';

    public static function options(): array
    {
        return [
            self::SINGER->value,
            self::BAND->value,
            self::PRODUCER->value,
            self::OTHER->value,
        ];
    }
}
