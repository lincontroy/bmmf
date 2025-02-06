<?php

namespace App\Http\Requests\Customer;

use App\Enums\AuthGuardEnum;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
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
        $uniqueRule = Rule::unique(Customer::class)->ignore(auth(AuthGuardEnum::CUSTOMER->value)->user()->id);

        return [
            'email'            => ['required', 'email', $uniqueRule],
            'first_name'       => ['required', 'string', 'min:2', 'max:100'],
            'last_name'        => ['required', 'string', 'min:2', 'max:100'],
            'phone'            => ['required', 'string', 'max:100', $uniqueRule],
            'country'          => ['required', 'string', 'min:2', 'max:100'],
            'state'            => ['nullable', 'string', 'max:100'],
            'city'             => ['required', 'string', 'min:2', 'max:100'],
            'address'          => ['nullable', 'string', 'max:100'],
            'language'         => ['required', 'string', 'min:2', 'max:100'],
            'account_password' => ['required', 'string', 'min:6', 'max:16'],
            'referral_user'    => ['nullable', 'string', 'max:100'],

        ];
    }

}
