<?php

namespace App\Http\Requests;

use App\Enums\MailMailerEnum;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class SettingEmailRequest extends FormRequest
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
        $mailMailers = MailMailerEnum::values();

        return [
            'MAIL_MAILER'       => ['required', 'in:' . implode(',', $mailMailers)],
            'MAIL_HOST'         => ['nullable', 'string'],
            'MAIL_PORT'         => ['nullable', 'numeric'],
            'MAIL_USERNAME'     => ['nullable', 'string'],
            'MAIL_PASSWORD'     => ['nullable', 'string'],
            'MAIL_ENCRYPTION'   => ['nullable', 'string'],
            'MAIL_FROM_ADDRESS' => ['nullable', 'string'],
            'MAIL_FROM_NAME'    => ['nullable', 'string'],
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
        ];
    }
}
