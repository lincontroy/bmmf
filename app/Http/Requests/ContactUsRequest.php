<?php

namespace App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
        return [
            'email'     => ['email:rfc,dns', 'required', 'string', 'min:5', 'max:50'],
            'full_name' => ['required', 'string', 'min:5', 'max:50'],
            'subject'   => ['required', 'string', 'min:5', 'max:200'],
            'message'   => ['required', 'string', 'min:5', 'max:2000'],
        ];
    }
}
