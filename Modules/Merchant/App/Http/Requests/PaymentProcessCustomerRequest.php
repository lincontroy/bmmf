<?php

namespace Modules\Merchant\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class PaymentProcessCustomerRequest extends FormRequest
{
    use FormRequestTrait;

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
            'email'      => ['required', 'email'],
            'first_name' => ['nullable', 'string', 'min:2', 'max:150'],
            'last_name'  => ['nullable', 'string', 'min:2', 'max:150'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
    }

}
