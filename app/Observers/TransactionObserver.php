<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Exceptions\TransactionShouldBeImmutable;

/**
 * Обработка событий, связанных с транзакциями
 * @package App\Observers
 */
class TransactionObserver
{
    /**
     * Пересчитываем баланс кошелька при создании новой транзакции
     *
     * @param Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transaction->account->recalculateBalance();
    }

    /**
     * Запрещаем изменение транзакций
     *
     * @param Transaction $transaction
     * @return void
     * @throws TransactionShouldBeImmutable
     */
    public function updating(Transaction $transaction)
    {
        throw new TransactionShouldBeImmutable('Transactions cannot be updated');
    }

    /**
     * Запрещаем удаление транзакций
     *
     * @param Transaction $transaction
     * @return void
     * @throws TransactionShouldBeImmutable
     */
    public function deleting(Transaction $transaction)
    {
        throw new TransactionShouldBeImmutable('Transactions cannot be removed');
    }
}
