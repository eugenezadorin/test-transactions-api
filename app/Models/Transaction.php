<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\DTO\TransactionData;
use App\Enums\TransactionType;
use App\Enums\TransactionReason;
use App\Enums\Currency;
use App\Services\CurrencyConverter;

class Transaction extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function createFromDto(TransactionData $data): self
    {
        $account = Account::findOrFail($data->account_id);

        $transaction = new self;
        $transaction->account_id = $account->id;
        $transaction->type = new TransactionType($data->type);
        $transaction->reason = new TransactionReason($data->reason);

        $transaction->base_amount = $data->amount;
        $transaction->base_currency = new Currency($data->currency);

        if ($account->currency->equals($transaction->base_currency)) {
            $transaction->amount = $data->amount;
            $transaction->currency = new Currency($data->currency);
        } else {
            $converter = new CurrencyConverter();
            $transaction->currency = $account->currency;
            $transaction->amount = $converter
                ->from($transaction->base_currency)
                ->to($account->currency)
                ->amount($data->amount)
                ->get();
        }

        return $transaction;
    }
}
