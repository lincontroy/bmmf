<?php

namespace Modules\QuickExchange\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuickExchangeTransactionVerifyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "transactionStatus"      => ["required", "in:0,1"],
            "admin_payment_tnx_hash" => $this->transactionStatus == 1 ? ["required", "string", "max:70"] : [],
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
