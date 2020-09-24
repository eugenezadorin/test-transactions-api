<?php

use App\Models\Transaction;
use App\Exceptions\TransactionShouldBeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('transaction cannot be removed', function () {

    $transaction = Transaction::factory()->create();
    $transaction->delete();

})->throws(TransactionShouldBeImmutable::class);

test('transaction cannot be changed', function () {

    $transaction = Transaction::factory()->create();
    $transaction->amount = 5000;
    $transaction->save();

})->throws(TransactionShouldBeImmutable::class);
