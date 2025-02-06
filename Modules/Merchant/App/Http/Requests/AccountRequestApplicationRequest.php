<?php

namespace Modules\Merchant\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequestApplicationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'store_name'  => ['required', 'string', 'min:2', 'max:150'],
            'email'       => ['required', 'email'],
            'about'       => ['nullable', 'string'],
            'phone'       => ['nullable', 'string'],
            'website_url' => ['nullable', 'string'],
            'logo'        => ["nullable", 'file', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ];
    }
}
