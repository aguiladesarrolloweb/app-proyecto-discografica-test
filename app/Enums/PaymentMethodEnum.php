<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CARD = 'Card';
    case PAYPAL = 'PayPal';
    case MERCADOPAGO = 'MercadoPago';
    case OTHER = 'Other';

    public static function options(): array
    {
        return [
            self::CARD->value,
            self::PAYPAL->value,
            self::MERCADOPAGO->value,
            self::OTHER->value,
        ];
    }
}
