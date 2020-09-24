<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use Sajya\Server\Procedure;
use App\Models\Account;
use App\Http\Requests\GetAccountBalanceRequest;

class GetAccountBalance extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'GetAccountBalance';

    /**
     * Execute the procedure.
     *
     * @param GetAccountBalanceRequest $request
     *
     * @return array|string|integer
     */
    public function handle(GetAccountBalanceRequest $request)
    {
        return Account::findOrFail($request->account_id)->balance;
    }
}
