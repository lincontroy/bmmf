<?php

namespace Modules\Support\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'msg_body' => ['required', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'msg_body' => 'message body',
        ];
    }

}
