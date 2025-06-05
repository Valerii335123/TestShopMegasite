<?php

declare (strict_types=1);

namespace App\Helpers;

class MoneyHelper
{

    /**
     * Number of minor units in one major unit (e.g. cents in a dollar).
     */
    private const MINOR_UNIT_FACTOR = 100;

    /**
     * Convert decimal units (e.g. 10.99) to minor units (e.g. 1099).
     */
    public static function toMinor(?float $decimalUnits): int
    {
        if (is_null($decimalUnits)) {
            return 0;
        }

        return (int)round($decimalUnits * self::MINOR_UNIT_FACTOR);
    }

    /**
     * Convert minor units (e.g. 1099) to decimal units (e.g. 10.99).
     */
    public static function toDecimal(?int $minorUnits): float
    {
        if (is_null($minorUnits)) {
            return 0;
        }

        return round($minorUnits / self::MINOR_UNIT_FACTOR, 2);
    }
}