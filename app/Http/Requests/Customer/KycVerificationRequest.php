<?php

namespace App\Http\Requests\Customer;

use App\Enums\GenderEnum;
use App\Enums\CustomerDocumentTypeEnum;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class KycVerificationRequest extends FormRequest
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
        $kycDocumentTypes = CustomerDocumentTypeEnum::values();
        $genders          = GenderEnum::values();

        return [
            'first_name'    => ['required', 'string', 'min:2', 'max:150'],
            'last_name'     => ['required', 'string', 'min:2', 'max:150'],
            'gender'        => ['required', 'string', 'in:' . implode(',', $genders)],
            'country'       => ['required', 'string', 'min:2', 'max:150'],
            'state'         => ['nullable', 'string', 'min:2', 'max:150'],
            'city'          => ['required', 'string', 'min:2', 'max:150'],
            'document_type' => ['required', 'string', 'in:' . implode(',', $kycDocumentTypes)],
            'document1'     => ["required", 'file', 'mimes:jpeg,jpg,png,gif', 'max:850'],
            'document2'     => ["required", 'file', 'mimes:jpeg,jpg,png,gif', 'max:850'],
            'id_number'     => ['required'],
            'expire_date'   => ['required'],
            'document3'     => ["required", 'file', 'mimes:jpeg,jpg,png,gif', 'max:850'],
        ];
    }

}
