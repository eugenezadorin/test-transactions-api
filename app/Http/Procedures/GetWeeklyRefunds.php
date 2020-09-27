<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use Sajya\Server\Procedure;
use Illuminate\Support\Facades\DB;
use App\Enums\TransactionReason;
use App\Enums\TransactionType;
use App\Enums\Currency;
use App\Services\CurrencyConverter;

class GetWeeklyRefunds extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'GetWeeklyRefunds';

    /**
     * Execute the procedure.
     *
     * @return array|string|integer
     */
    public function handle()
    {
        $query = "
            select SUM(amount) as sum, currency
            from transactions
            where reason = :reason
            and type = :type
            and created_at >= DATE('now','-7 days')
            group by account_id;
        ";

        $rows = DB::select($query, [
            'reason' => TransactionReason::refund(),
            'type' => TransactionType::debit(),
        ]);

        $total = 0;
        $conv = new CurrencyConverter;

        foreach ($rows as $row) {
            $sum = (int)$row->sum;
            $currency = new Currency($row->currency);

            if ($currency->equals(Currency::RUB())) {
                $total += $sum;
            } else {
                $total += $conv->from($currency)->to(Currency::RUB())->amount($sum)->get();
            }
        }

        return [
            'amount' => $total,
            'currency' => Currency::RUB(),
        ];
    }
}
