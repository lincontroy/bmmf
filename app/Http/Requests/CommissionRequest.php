<?php

namespace App\Http\Requests;

use App\Enums\SiteAlignEnum;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommissionRequest extends FormRequest
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
            "level"             => ["required", "array"],
            "level.*"           => ["required", "integer", "gt:0"],
            "personal_invest"   => ["required", "array"],
            "personal_invest.*" => ["required", "integer", "gt:0"],
            "total_invest"      => ["required", "array"],
            "total_invest.*"    => ["required", "integer", "gt:0"],
            "team_bonus"        => ["required", "array"],
            "team_bonus.*"      => ["required", "integer", "gt:0"],
            "referral_bonus"    => ["required", "array"],
            "referral_bonus.*"  => ["required", "integer", "gt:0"],
        ];
    }
}
