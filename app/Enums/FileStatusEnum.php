<?php

namespace App\Enums;

enum FileStatusEnum: string
{
    case ACTIVE = 'active';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case DELETED = 'deleted';

    public static function options(): array
    {
        return [
            self::ACTIVE->value,
            self::PROCESSING->value,
            self::COMPLETED->value,
            self::DELETED->value,
        ];
    }
}
