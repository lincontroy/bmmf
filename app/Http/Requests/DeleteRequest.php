<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $fullClass = explode('\\', Route::currentRouteAction());
        $segments = explode('@', $fullClass[count($fullClass) - 1]);
        $resourceName = Str::of(str_replace('Controller', '', $segments[0]))
            ->lower()
            ->singular();
        return $this->user()->hasPermissionTo($resourceName . '_delete');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric'],
        ];
    }
}