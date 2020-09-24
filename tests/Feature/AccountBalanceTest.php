<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Account;
use App\Models\Transaction;
use App\Enums\TransactionType;

uses(RefreshDatabase::class);

test('account has zero balance by default', function () {
    $account = Account::factory()->create();
    $balance = $account->recalculateBalance();
    expect($balance)->toBe(0);
});

test('account balance recalculates on every transaction', function () {
    $account = Account::factory()->create();

    $addMoney = Transaction::factory()->create([
        'account_id' => $account->id,
        'type' => TransactionType::debit(),
        'amount' => 5000
    ]);

    $account->refresh();
    expect($account->balance)->toBe(5000);

    $removeMoney = Transaction::factory()->create([
        'account_id' => $account->id,
        'type' => TransactionType::credit(),
        'amount' => 3000
    ]);

    $account->refresh();
    expect($account->balance)->toBe(2000);
});
