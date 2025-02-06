<?php

namespace Modules\Finance\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
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
            'user_id'            => ['required'],
            'accept_currency_id' => ['required', 'integer'],
            'amount'             => ['required', 'numeric', 'gt:0'],
            'note'               => ['required', 'string'],
        ];
    }

    /**
     * Get package attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'accept_currency_id' => 'accept currency',
            'user_id'            => 'user ID',
            'amount'             => 'amount',
            'note'               => 'notes',
        ];
    }
}
