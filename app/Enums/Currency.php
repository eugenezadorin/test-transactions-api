<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self RUB()
 * @method static self USD()
 */
class Currency extends Enum
{
    // @todo create BaseEnum class with all() method
    public static function all(): array
    {
        return [
            (string)self::RUB(),
            (string)self::USD(),
        ];
    }
}
