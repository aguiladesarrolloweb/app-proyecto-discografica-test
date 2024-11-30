<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CARD = 'Card';
    case PAYPAL = 'PayPal';
    case TRANSACTION = 'Transaction';

    public static function options(): array
    {
        return [
            self::CARD->value,
            self::PAYPAL->value,
            self::TRANSACTION->value,
        ];
    }
}
