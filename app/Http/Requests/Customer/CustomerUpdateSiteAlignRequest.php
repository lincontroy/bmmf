<?php

namespace App\Http\Requests\Customer;

use App\Enums\SiteAlignEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateSiteAlignRequest extends FormRequest
{

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
        $siteAligns = SiteAlignEnum::values();

        return [
            'site_align' => ['required', 'string', 'in:' . implode(',', $siteAligns)],
        ];
    }

}
