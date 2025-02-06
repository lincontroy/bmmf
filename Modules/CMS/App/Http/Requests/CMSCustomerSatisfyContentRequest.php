<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\ArticleTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Article;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSCustomerSatisfyContentRequest extends FormRequest
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
                          ->where('slug', ArticleTypeEnum::CUSTOMER_SATISFY_CONTENT->value);

        $statues   = StatusEnum::values();
        $imageRule = "required";

        if (!empty($this->articleId)) {
            $uniqueRule = $uniqueRule->ignore($this->articleId);
            $imageRule  = "nullable";
        }

        return [
            "customer_satisfy_content"      => ["required", "string", $uniqueRule],
            'image'                         => [$imageRule, 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'language_id'                   => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "satisfy_customer_name"         => ["required", "string"],
            "designation"                   => ["required", "string"],
            "satisfy_customer_company_name" => ["required", "string"],
            "satisfy_customer_company_url"  => ["required", "string"],
            "satisfy_customer_message"      => ["required", "string"],
            "status"                        => ["required", "string", 'in:' . implode(',', $statues)],
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
