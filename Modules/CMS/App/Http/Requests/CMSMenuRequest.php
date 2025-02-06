<?php

namespace Modules\CMS\App\Http\Requests;

use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CMSMenuRequest extends FormRequest
{
    use FormRequestTrait;

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
        return [
            "menu_slug"   => ["required", "string"],
            'language_id' => ['nullable', 'integer', Rule::exists(Language::class, 'id')],
            "menu_name"   => ["required", "string"],
        ];
    }

}
