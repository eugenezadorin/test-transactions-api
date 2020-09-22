<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @todo Recalculate balance of connected account
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "updating" event.
     *
     * @todo deprecate updating of transaction to keep history
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updating(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "deleting" event.
     *
     * @todo deprecate removing of transaction to keep history
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleting(Transaction $transaction)
    {
        //
    }
}
