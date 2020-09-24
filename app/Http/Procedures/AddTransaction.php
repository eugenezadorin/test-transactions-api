<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\AddTransactionRequest;
use Sajya\Server\Procedure;
use App\Models\Transaction;
use App\Enums\TransactionType;
use App\Enums\TransactionReason;
use App\Enums\Currency;

class AddTransaction extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'AddTransaction';

    /**
     * Execute the procedure.
     *
     * @param AddTransactionRequest $request
     *
     * @return array|string|integer
     */
    public function handle(AddTransactionRequest $request)
    {
        $transaction = Transaction::createFromDto($request->getData());
        $transaction->save();
        return [
            'message' => 'Transaction successfully created',
            'data' => ['transaction_id' => $transaction->id],
        ];
    }
}
