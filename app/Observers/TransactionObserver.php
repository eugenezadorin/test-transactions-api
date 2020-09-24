<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Exceptions\TransactionShouldBeImmutable;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transaction->account->recalculateBalance();
    }

    /**
     * Handle the transaction "updating" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updating(Transaction $transaction)
    {
        throw new TransactionShouldBeImmutable('Transactions cannot be updated');
    }

    /**
     * Handle the transaction "deleting" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleting(Transaction $transaction)
    {
        throw new TransactionShouldBeImmutable('Transactions cannot be removed');
    }
}
