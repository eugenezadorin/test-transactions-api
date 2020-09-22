<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use Illuminate\Http\Request;
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
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function handle(Request $request)
    {
        // @todo add separate request class and validation logic
        $transaction = new Transaction;
        $transaction->account_id = $request->account_id;
        $transaction->type = new TransactionType($request->type);
        $transaction->amount = $request->amount;
        $transaction->currency = new Currency($request->currency);
        $transaction->reason = new TransactionReason($request->reason);

        $transaction->save();
        return [
            'message' => 'Transaction successfully created',
            'data' => ['transaction_id' => $transaction->id],
        ];
    }
}
