<?php

namespace Modules\Package\App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PackageBuyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'package_id' => ['integer'],
            'quantity'   => ['required', 'numeric', 'min:1'],
            'investAmt'  => ['required', 'numeric'],
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
            'package_id' => 'package id',
            'quantity'   => 'quantity',
            'investAmt'  => 'investment amount',
        ];
    }

}
