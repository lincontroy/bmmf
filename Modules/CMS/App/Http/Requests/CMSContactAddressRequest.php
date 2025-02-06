<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\ArticleTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Article;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSContactAddressRequest extends FormRequest
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
        $uniqueRule = Rule::unique(Article::class, 'article_name')
            ->where('slug', ArticleTypeEnum::Blog->value);

        $statues = StatusEnum::values();

        if (!empty($this->articleId)) {
            $uniqueRule = $uniqueRule->ignore($this->articleId);
        }

        return [
            "contact_address"          => ["required", "string", $uniqueRule],
            'language_id'              => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "contact_address_place"    => ["required", "string"],
            "contact_address_location" => ["required", "string"],
            "contact_address_contact"  => ["required", "string"],
            "status"                   => ["required", "string", 'in:' . implode(',', $statues)],
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
