<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self stock()
 * @method static self refund()
 */
class TransactionReason extends Enum
{
    public static function all(): array
    {
        return [
            (string)self::stock(),
            (string)self::refund(),
        ];
    }
}
