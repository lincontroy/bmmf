<?php

namespace App\Http\Requests;

use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Language id
     *
     * @var int|null
     */
    private ?int $languageId;

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
        $uniqueRule = Rule::unique(Language::class);

        if (!empty($this->languageId)) {
            $uniqueRule = $uniqueRule->ignore($this->languageId);
        }

        return [
            'name'     => ['required', 'string', $uniqueRule],
            'symbol'   => ['required', 'string', $uniqueRule],
            'logo'     => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'old_logo' => ['nullable', 'string'],
        ];

    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->languageId = $this->route('language');
    }

}
