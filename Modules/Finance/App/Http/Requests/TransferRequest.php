<?php

namespace Modules\Finance\App\Http\Requests;

use App\Models\AcceptCurrency;
use App\Rules\UserExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "payment_currency"  => ["required", "string", Rule::exists(AcceptCurrency::class, 'symbol')],
            "receiver_user"     => ["required", "string", new UserExists],
            "transfer_amount"   => ["required", "numeric", "gt:0"],
            "transfer_comments" => ["nullable", "string"],
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
