<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case FAILED = 'Failed';
    case CANCELED = 'Canceled';

    public static function options(): array
    {
        return [
            self::PENDING->value,
            self::COMPLETED->value,
            self::FAILED->value,
            self::CANCELED->value,
        ];
    }
}
