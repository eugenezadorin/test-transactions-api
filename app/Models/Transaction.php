<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DTO\TransactionData;
use App\Enums\TransactionType;
use App\Enums\TransactionReason;
use App\Enums\Currency;

class Transaction extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function createFromDto(TransactionData $data): self
    {
        $transaction = new self;
        $transaction->account_id = $data->account_id;
        $transaction->type = new TransactionType($data->type);
        $transaction->amount = $data->amount;
        $transaction->currency = new Currency($data->currency);
        $transaction->reason = new TransactionReason($data->reason);
        return $transaction;
    }
}
