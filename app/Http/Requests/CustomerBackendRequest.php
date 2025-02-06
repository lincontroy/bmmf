<?php

namespace App\Http\Requests;

use App\Models\Customer;
use App\Models\User;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerBackendRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * User id
     *
     * @var int|null
     */
    private ?int $customerId;

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
        $uniqueRule = Rule::unique(Customer::class)->where(function ($query) {
            $query->whereNull('email');
            $query->whereNull('phone');
        });

        $rules = [
            'first_name'    => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'last_name'     => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'referral_user' => ['nullable'],
            'status'        => ['required', 'max:1'],
        ];

        if (!empty($this->customerId)) {
            $uniqueRule        = $uniqueRule->ignore($this->customerId);
            $rules['password'] = ['nullable', 'min:8'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'max:16', 'confirmed'];
        }

        if ($this->input('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'max:16', 'confirmed'];
        }

        $rules['email'] = ['email:rfc,dns', 'required', 'string', 'min:5', 'max:50', $uniqueRule];
        $rules['phone'] = ['required', 'string', 'min:2', 'max:20', $uniqueRule];

        return $rules;
    }

    public function messages()
    {
        return [
            'password.regex' => 'The :attribute must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->customerId = $this->route('customer');
    }

}
