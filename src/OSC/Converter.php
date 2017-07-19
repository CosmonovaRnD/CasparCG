<?php

namespace CosmonovaRnD\CasparCG\OSC;

/**
 * Class Converter
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC
 * Cosmonova | Research & Development
 */
class Converter
{
    public static function convert(string $bin, string $type)
    {
        switch ($type) {
            case 'i':
                return self::int32($bin);
            case 'h':
            case 't':
                return self::int64($bin);
            case 'f':
                return self::float32($bin);
            case 'd':
                return self::float64($bin);
            case 's':
            case 'b':
                return self::string($bin);
            case 'c':
                return self::char($bin);
            case 'T':
                return true;
            case 'F':
                return false;
            case 'N':
            case 'I':
                return null;
            default:
                return null;
        }
    }

    public static function int32(string $bin): int
    {
        $res = unpack('Nval', substr($bin, 0, 4));

        return $res['val'];
    }

    public static function int64(string $bin): int
    {
        $res = unpack('Jval', substr($bin, 0, 8));

        return $res['val'];
    }

    public static function float32(string $bin): float
    {
        $res = unpack('fval', strrev(substr($bin, 0, 4)));

        return $res['val'];
    }

    public static function float64(string $bin): float
    {
        $res = unpack('dval', strrev(substr($bin, 0, 8)));

        return $res['val'];
    }

    public static function string(string $bin): string
    {
        $res = unpack('a*val', $bin);

        return $res['val'];
    }

    public static function char(string $bin): string
    {
        $res = unpack('cval', substr($bin, 0, 1));

        return $res['val'];
    }

    public static function getTypeBytes(string $type)
    {
        $typeBytesLen = [
            'i' => 4,
            'f' => 4,
            's' => null,
            'b' => null,
            'h' => 8,
            't' => 8,
            'd' => 8,
            'T' => 0,
            'F' => 0,
            'N' => 0,
        ];

        return $typeBytesLen[$type] ?? null;
    }
}
