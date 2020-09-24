<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class TransactionData extends DataTransferObject
{
    public int $account_id;

    public string $type;

    public int $amount;

    public string $currency;

    public string $reason;
}
