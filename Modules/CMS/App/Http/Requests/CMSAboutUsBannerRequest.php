<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\StatusEnum;
use App\Models\Article;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSAboutUsBannerRequest extends FormRequest
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
        $uniqueRule = Rule::unique(Article::class, 'article_name');
        $statues    = StatusEnum::values();
        $imageRule  = "required";

        if (!empty($this->articleId)) {
            $uniqueRule = $uniqueRule->ignore($this->articleId);
            $imageRule  = "nullable";
        }

        return [
            "about_us_banner"       => ["required", "string", $uniqueRule],
            'banner_image'          => [$imageRule, 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'banner_language_id'    => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "about_us_banner_title" => ["required", "string"],
            "banner_status"         => ["required", "string", 'in:' . implode(',', $statues)],
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
