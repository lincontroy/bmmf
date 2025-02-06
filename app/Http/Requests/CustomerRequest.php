<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CustomerRequest extends FormRequest
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
        return [
            'email'      => ['email:rfc,dns', 'required', 'string', 'min:5', 'max:50', 'unique:customers,email'],
            'phone'      => ['required', 'string', 'min:2', 'max:30', 'unique:customers,phone'],
            'first_name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'last_name'  => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'username'   => ['required', 'string', 'min:3', 'max:100', 'unique:customers,username'],
            'country'    => ['required', 'string', 'min:1', 'max:20'],
            'password'   => ['required', 'string', 'min:8', 'max:16', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'The :attribute must contain at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error'   => 'Validation failed',
            'message' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
