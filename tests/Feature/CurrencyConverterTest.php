<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Services\CurrencyConverter;
use App\Enums\Currency;

uses(RefreshDatabase::class);

beforeEach(function () {
    DB::insert('insert into currency_rates (currency_from, currency_to, rate) values (?, ?, ?)', [
        Currency::RUB(),
        Currency::USD(),
        0.013018
    ]);

    DB::insert('insert into currency_rates (currency_from, currency_to, rate) values (?, ?, ?)', [
        Currency::USD(),
        Currency::RUB(),
        76.8195
    ]);
});

it('properly converts RUB into USD', function () {
    $conv = new CurrencyConverter;
    $result = $conv->from(Currency::RUB())->to(Currency::USD())->amount(1000)->get();
    expect($result)->toBe(13);
});

it('properly converts USD into RUB', function () {
    $conv = new CurrencyConverter;
    $result = $conv->from(Currency::USD())->to(Currency::RUB())->amount(1000)->get();
    expect($result)->toBe(76820);
});
