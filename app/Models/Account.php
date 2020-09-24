<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TransactionType;
use App\Casts\Currency;

class Account extends Model
{
    use HasFactory;

    protected $casts = [
        'balance' => 'integer',
        'currency' => Currency::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function recalculateBalance(): int
    {
        $debit = $this->transactions()->where('type', TransactionType::debit())->sum('amount');
        $credit = $this->transactions()->where('type', TransactionType::credit())->sum('amount');

        $this->balance = $debit - $credit;
        $this->save();
        return $this->balance;
    }
}
