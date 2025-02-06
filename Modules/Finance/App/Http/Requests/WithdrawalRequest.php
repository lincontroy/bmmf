<?php

namespace Modules\Finance\App\Http\Requests;

use App\Models\AcceptCurrency;
use App\Models\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawalRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "payment_method"      => ["required", "integer", Rule::exists(PaymentGateway::class, 'id')],
            "payment_currency"    => ["required", "integer", Rule::exists(AcceptCurrency::class, 'id')],
            "withdraw_amount"     => ["required", "numeric", "gt:0"],
            "withdrawal_comments" => ["nullable", "string"],
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
