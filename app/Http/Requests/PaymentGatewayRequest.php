<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "gateway_name"           => ["required", "string", "max:50"],
            "min_transaction_amount" => ["required", "numeric", "gt:0"],
            "max_transaction_amount" => ["required", "numeric", "gt:0", "gt:min_transaction_amount"],
            "credential_name.*"      => ["required", "string", "max:30"],
            "credential_value.*"     => ["required", "string", "max:150"],
            "status"                 => ["required", "string", "min:1"],
        ];
    }
}
