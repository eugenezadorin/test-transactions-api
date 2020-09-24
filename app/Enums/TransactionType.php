<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self debit()
 * @method static self credit()
 */
class TransactionType extends Enum
{
    public static function all(): array
    {
        return [
            (string)self::debit(),
            (string)self::credit(),
        ];
    }
}
