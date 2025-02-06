<?php

namespace Modules\Finance\App\Http\Requests;

use App\Models\AcceptCurrency;
use App\Models\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawalAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "payment_method"   => ["required", "integer", Rule::exists(PaymentGateway::class, 'id')],
            "payment_currency" => ["required", "string", Rule::exists(AcceptCurrency::class, 'symbol')],
            "account_label.*"  => ["required", "string", "min:5", "max:255"],
            "account_value.*"  => ["required", "string", "min:5", "max:255"],
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
