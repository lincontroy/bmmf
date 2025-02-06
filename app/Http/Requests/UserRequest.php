<?php

namespace App\Http\Requests;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * User id
     *
     * @var int|null
     */
    private ?int $userId;

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
        $uniqueRule = Rule::unique(User::class)->where(function ($query) {
            $query->whereNull('deleted_at');
            $query->orWhereNotNull('deleted_at');
        });

        $rules = [
            'first_name'    => ['required', 'string'],
            'last_name'     => ['required', 'string'],
            'role_id'       => ['nullable', 'array', 'min:1', Rule::exists(Role::class, 'id')],
            'permissions'   => ['nullable', 'array', 'min:1'],
            'permissions.*' => ['nullable', 'integer', 'integer', Rule::exists(Permission::class, 'id')],
            'image'         => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
        ];

        if (!empty($this->userId)) {
            $uniqueRule        = $uniqueRule->ignore($this->userId);
            $rules['password'] = ['nullable', 'min:6'];
        } else {
            $rules['password'] = ['required', 'min:6'];
        }

        $rules['email'] = ['required', 'string', $uniqueRule];

        return $rules;

    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->userId = $this->route('user');
    }

}
