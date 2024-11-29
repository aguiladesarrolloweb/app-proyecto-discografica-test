<?php

namespace App\Enums;

enum DiscountTypeEnum: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';

    public static function options(): array
    {
        return [
            self::PERCENTAGE->value,
            self::FIXED->value,
        ];
    }
}
