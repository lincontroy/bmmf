<?php

namespace Modules\Merchant\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantFeeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'accept_currency_id' => [],
            'percent.*' => ["required", "numeric", "gte:0"],
        ];

    }

}
