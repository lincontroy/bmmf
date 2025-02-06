<?php

namespace Modules\Stake\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StakeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "accept_currency" => ["required", "numeric"],
            "stake_title"     => ["required", "string", "min:2", "max:50"],
            'image'           => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            "duration.*"      => ["required", "integer", "gt:0"],
            "min_value.*"     => ["required", "numeric", "gt:0"],
            "max_value.*"     => ["required", "numeric", "gt:0", "gt:min_value.*"],
            "interest_rate.*" => ["required", "numeric", "gt:0"],
            "status"          => ["nullable"],
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
