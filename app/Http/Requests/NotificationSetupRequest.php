<?php

namespace App\Http\Requests;

use App\Enums\SiteAlignEnum;
use App\Models\NotificationSetup;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationSetupRequest extends FormRequest
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
            'notification_setup'   => ['nullable', 'array', 'min:1'],
            'notification_setup.*' => ['nullable', 'integer', 'integer', Rule::exists(NotificationSetup::class, 'id')],
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
