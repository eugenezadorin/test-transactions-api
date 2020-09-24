<?php

namespace App\Services;

use App\Enums\Currency;

final class CurrencyConverter
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

    // @todo add convertation logic
    public function get(): int
    {
        return $this->amount;
    }
}
