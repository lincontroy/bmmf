<?php

namespace App\Http\Requests;

use App\Enums\SiteAlignEnum;
use App\Models\Language;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $site_aligns = SiteAlignEnum::values();

        return [
            'title'              => ['required', 'string'],
            'email'              => ['required', 'string'],
            'language_id'        => ['nullable', 'integer', Rule::exists(Language::class, 'id')],
            'site_align'         => ['nullable', 'string', 'in:' . implode(',', $site_aligns)],
            'footer_text'        => ['nullable', 'string'],
            'logo'               => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'old_logo'           => ['nullable', 'string'],
            'description'        => ['nullable', 'string'],
            'phone'              => ['nullable', 'string'],
            'time_zone'          => ['required', 'string'],
            'office_time'        => ['nullable', 'string'],
            'latitude_longitude' => ['nullable', 'string'],
            'favicon'            => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'old_favicon'        => ['nullable', 'string'],
            'login_bg_img'       => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'old_login_bg_img'   => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'language_id' => 'Language',
        ];
    }

}
