<?php

namespace Modules\CMS\App\Http\Requests;

use App\Enums\StatusEnum;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSTeamMemberBannerRequest extends FormRequest
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
            "team_member_banner"       => ["required", "string"],
            'banner_image'             => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'banner_language_id'       => ['required', 'integer', Rule::exists(Language::class, 'id')],
            "team_member_banner_title" => ["required", "string"],
            "banner_status"            => ["required", "string", 'in:' . implode(',', $statues)],
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
