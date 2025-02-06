<?php

namespace Modules\QuickExchange\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuickExchangeAddCoinRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "coinType"              => 'nullable|integer',
            "coin_name"             => ["required", "string", "min:2", "max:50"],
            "symbol"                => ["required", "string", "min:2", "max:30"],
            "reserve_balance"       => ["required", "numeric", "gt:0"],
            "min_transaction"       => ["required", "numeric", "gt:0"],
            "buy_adjust_price"      => [Rule::requiredIf($this->filled('coinType')), "numeric", "gte:0"],
            "sell_adjust_price"     => [Rule::requiredIf($this->filled('coinType')), "numeric", "gte:0"],
            "market_rate"           => [Rule::requiredIf($this->filled('coinType')), "numeric", "gt:0"],
            "account_label_name.*"  => [Rule::requiredIf($this->filled('coinType')), "string", "min:2", "max:100"],
            "account_label_value.*" => [Rule::requiredIf($this->filled('coinType')), "string", "min:2", "max:100"],
            "wallet_id"             => ["required_if:coinType,null", "string", "min:2", "max:100"],
            "status"                => ["required", "string", "min:1"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
