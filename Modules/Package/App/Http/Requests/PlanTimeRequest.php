<?php

namespace Modules\Package\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlanTimeRequest extends FormRequest
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
            'name_'  => ['required', 'string'],
            'hours_' => ['required', 'int', 'gt:0'],
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
            'name_'  => 'Time name',
            'hours_' => 'Time hours',
        ];
    }

}
