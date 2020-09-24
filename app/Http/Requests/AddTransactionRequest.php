<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TransactionType;
use App\Enums\TransactionReason;
use App\Enums\Currency;
use App\DTO\TransactionData;

class AddTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required|exists:App\Models\Account,id',
            'type' => ['required', Rule::in(TransactionType::all())],
            'amount' => 'required|integer',
            'currency' => ['required', Rule::in(Currency::all())],
            'reason' => ['required', Rule::in(TransactionReason::all())],
        ];
    }

    public function getData(): TransactionData
    {
        return new TransactionData($this->validated());
    }
}
