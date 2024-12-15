<?php

namespace App\Enums;

enum FormStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function options(): array
    {
        return [
            self::PENDING->value,
            self::PROCESSING->value,
            self::APPROVED->value,
            self::REJECTED->value,
        ];
    }
}
