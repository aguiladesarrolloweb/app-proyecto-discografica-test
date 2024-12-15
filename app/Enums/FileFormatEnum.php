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

    public static function getEnumFromFileExtension(string $extension): ?self
    {
        // Convertimos la extensión a mayúsculas para asegurar que coincida con el Enum
        $extension = strtoupper($extension);

        // Hacemos un "switch" o un "array" para mapear la extensión a un Enum
        return match ($extension) {
            'WAV' => self::WAV,
            'ZIP' => self::ZIP,
            'RAR' => self::RAR,
            'FLC' => self::FLC,
            'AIF' => self::AIF,
            default => null, // Si la extensión no coincide, retornamos null
        };
    }
}
