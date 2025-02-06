<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\StatusEnum;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSInvestmentRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Article id
     *
     * @var int|null
     */
    private ?int $articleId;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $statues   = StatusEnum::values();

        return [
            "investment_name"           => ["required", "string"],
            'image'                     => ["nullable", 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            "button_link"               => ["nullable", "string"],
            'language_id'               => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "investment_header_title"   => ["required", "string"],
            "investment_header_content" => ["required", "string"],
            "investment_button_text"    => ["nullable", "string"],
            "status"                    => ["required", "string", 'in:' . implode(',', $statues)],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->articleId = $this->route('article');
    }

}
