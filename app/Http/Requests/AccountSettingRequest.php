<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountSettingRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * User id
     *
     * @var int|null
     */
    private ?int $userId;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueRule = Rule::unique(User::class)->where(function ($query) {
            $query->whereNull('email');
        });

        $rules = [
            'about'      => ['nullable', 'max:500'],
            'first_name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'last_name'  => ['required', 'string', 'min:1', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'image'      => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:500'],
        ];

        if ($this->input('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'max:16'];
        }

        $rules['email'] = ['email:rfc,dns', 'required', 'string', 'min:5', 'max:50', $uniqueRule];

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->userId = request()->route()->parameter('id');
    }

}
