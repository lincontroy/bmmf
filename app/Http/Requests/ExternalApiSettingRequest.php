<?php

namespace App\Http\Requests;

use App\Enums\FeeSettingLevelEnum;
use App\Models\FeeSetting;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExternalApiSettingRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Fee Setting id
     *
     * @var int|null
     */
    private ?int $feeSettingId;

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
            'url' => ['required', 'string'],
            'api_key'   => ['required', 'min:1', 'max:200'],
        ];
    }

}
