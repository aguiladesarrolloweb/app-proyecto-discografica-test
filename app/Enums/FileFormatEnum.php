<?php

namespace App\Enums;

enum FileFormatEnum: string
{
    case WAV = 'WAV';
    case ZIP = 'ZIP';
    case RAR = 'RAR';
    case FLC = 'FLC';
    case AIF = 'AIF';

    public static function options(): array
    {
        return [
            self::WAV->value,
            self::ZIP->value,
            self::RAR->value,
            self::FLC->value,
            self::AIF->value,
        ];
    }
}
