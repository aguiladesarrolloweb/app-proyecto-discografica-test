<?php

namespace App\Enums;

enum CurrencyEnum: string
{

    case USD = 'USD';
    case EUR = 'EUR';
    case MXN = 'MXN';
    case GBP = 'GBP';
    case CAD = 'CAD';
    case JPY = 'JPY';
    case AUD = 'AUD';
    case BRL = 'BRL';
    case ARS = 'ARS';

    public static function options(): array
    {
        return [
            self::USD->value,
            self::EUR->value,
            self::MXN->value,
            self::GBP->value,
            self::CAD->value,
            self::JPY->value,
            self::AUD->value,
            self::BRL->value,
            self::ARS->value,
        ];
    }
}
