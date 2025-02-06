<?php

namespace Modules\Package\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'plan_time_id'  => ['required'],
            'name'          => ['required'],
            'invest_type'   => ['required', 'gte:0'],
            'interest_type' => ['required', 'gte:0'],
            'interest'      => ['required', 'gte:0'],
            'return_type'   => ['required', 'integer'],
            'image'         => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            'image_logo'    => ['nullable', 'string'],
        ];

        if (!empty($this->input('invest_type')) && $this->input('invest_type') == '1') {

            $rules['min_price'] = ['required', 'lte:max_price', 'gt:0'];
            $rules['max_price'] = ['required', 'gte:0'];
        } else {
            $rules['amount'] = ['required', 'gte:0'];
        }

        if (!empty($this->input('return_type') && $this->input('return_type') == '2')) {
            $rules['repeat_time']  = ['required', 'int', 'gt:0'];
            $rules['capital_back'] = ['required'];
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'max_price.lte' => 'The minimum value must not be greater than the maximum value.',
        ];
    }

    /**
     * Get package attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'plan_time_id'  => 'Time',
            'name'          => 'plan name',
            'invest_type'   => 'invest type',
            'min_price'     => 'min price',
            'max_price'     => 'max price',
            'interest_type' => 'interest type',
            'interest'      => 'interest',
            'return_type'   => 'return type',
            'repeat_time'   => 'repeat time',
            'capital_back'  => 'capital back',
        ];
    }

}
