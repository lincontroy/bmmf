<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\StatusEnum;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSMerchantTitleRequest extends FormRequest
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
        $statues = StatusEnum::values();

        return [
            "merchant_title"         => ["required", "string"],
            'title_language_id'      => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "merchant_title_header"  => ["required", "string"],
            "merchant_title_content" => ["required", "string"],
            "title_status"           => ["required", "string", 'in:' . implode(',', $statues)],
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
