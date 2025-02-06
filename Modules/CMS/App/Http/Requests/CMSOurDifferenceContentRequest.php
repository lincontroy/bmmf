<?php

namespace Modules\CMS\App\Http\Requests;

use App\Models\Article;
use App\Models\Language;
use App\Enums\StatusEnum;
use App\Enums\ArticleTypeEnum;
use Illuminate\Validation\Rule;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class CMSOurDifferenceContentRequest extends FormRequest
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
            ->where('slug', ArticleTypeEnum::OUR_DIFFERENCE_CONTENT->value);

        $statues   = StatusEnum::values();
        $imageRule = "required";

        if (!empty($this->articleId)) {
            $uniqueRule = $uniqueRule->ignore($this->articleId);
            $imageRule  = "nullable";
        }

        return [ 
            "our_difference_content"        => ["required", "string", $uniqueRule],
            'image'                         => [$imageRule, 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'language_id'                   => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "our_difference_content_header" => ["required", "string"],
            "our_difference_content_body"   => ["required", "string"],
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
