<?php

namespace Modules\B2xloan\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'no_of_month'      => ['required', 'integer', 'gt:0', 'max:104'],
            'interest_percent' => ['required', 'numeric', 'gt:0', 'max:100'],
            'status'           => ['required'],
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
            'no_of_month'      => 'Number of month',
            'interest_percent' => 'Interest percent',
            'status_mehedi'    => 'Status',
        ];
    }

}
