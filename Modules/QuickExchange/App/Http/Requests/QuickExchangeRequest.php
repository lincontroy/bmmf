<?php

namespace Modules\QuickExchange\App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class QuickExchangeRequest extends FormRequest
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
            'sell_coin'        => ['required', 'string', 'min:1', 'max:30'],
            'buy_coin'         => ['required', 'string', 'min:1', 'max:30'],
            'sell_amount'      => ['required', 'numeric', 'gte:0'],
            'buy_amount'       => ['required', 'numeric', 'gte:0'],
            'transaction'      => ['required', 'string', 'min:5', 'max:70', 'unique:quick_exchange_requests,user_send_hash'],
            'receiver_account' => ['required', 'string', 'min:5', 'max:50'],
            'tx_image'         => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error'   => localize('Validation failed'),
            'message' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
