<?php

namespace App\Http\Requests;

use App\Enums\FeeSettingLevelEnum;
use App\Models\FeeSetting;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeeSettingRequest extends FormRequest
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
        $feeSettingLevels = FeeSettingLevelEnum::values();

        $uniqueRule = Rule::unique(FeeSetting::class);

        if (!empty($this->feeSettingId)) {
            $uniqueRule = $uniqueRule->ignore($this->feeSettingId);
        }

        return [
            'level' => ['required', 'string', 'in:' . implode(',', $feeSettingLevels), $uniqueRule],
            'fee'   => ['required', 'min:0', 'max:100', 'numeric'],
        ];

    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->feeSettingId = $this->route('fee_setting');
    }

}
