<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Account;
use App\Enums\TransactionType;
use App\Enums\TransactionReason;
use App\Enums\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'type' => TransactionType::debit(),
            'amount' => 1000,
            'currency' => Currency::RUB(),
            'base_amount' => 1000,
            'base_currency' => Currency::RUB(),
            'reason' => TransactionReason::refund(),
        ];
    }
}
