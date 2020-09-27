<?php

namespace App\Services;

use App\Enums\Currency;
use App\Exceptions\CurrencyCannotBeConverted;
use Illuminate\Support\Facades\DB;

/**
 * Конвертирует валюты согласно курсам из таблицы currency_rates,
 * которая ежедневно актуализируется данными ЦБ РФ
 * @see App\Console\Commands\RefreshCurrencyRates
 * @package App\Services
 */
class CurrencyConverter
{
    private Currency $from;

    private Currency $to;

    private int $amount;

    public function from(Currency $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function to(Currency $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function amount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function get(): int
    {
        $cacheId = sprintf('currency_rate_%s_%s', $this->from, $this->to);
        $cacheTtl = 3600; // 1 hour
        $rate = cache()->remember($cacheId, $cacheTtl, function() {
            $rows = DB::select('select rate from currency_rates where currency_from = ? and currency_to = ?', [
                $this->from,
                $this->to
            ]);
            if (empty($rows)) {
                throw new CurrencyCannotBeConverted(sprintf('Cannot convert %s into %s', $this->from, $this->to));
            }
            return (float)$rows[0]->rate;
        });
        return (int)round($this->amount * $rate);
    }
}
