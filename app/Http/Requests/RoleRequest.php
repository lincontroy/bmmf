<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Role id
     *
     * @var int|null
     */
    private ?int $roleId;

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
        $uniqueRule = Rule::unique(Role::class);

        if (!empty($this->roleId)) {
            $uniqueRule = $uniqueRule->ignore($this->roleId);
        }

        return [
            'name'          => ['required', 'string', $uniqueRule],
            'permissions'   => ['nullable', 'array', 'min:1'],
            'permissions.*' => ['nullable', 'integer', 'integer'],
        ];

    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->roleId = $this->route('role');
    }

}
