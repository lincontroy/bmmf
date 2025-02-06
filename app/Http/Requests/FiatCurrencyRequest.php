<?php

namespace App\Http\Requests;

use App\Enums\CommonStatusEnum;
use App\Models\FiatCurrency;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FiatCurrencyRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Fiat Currency id
     *
     * @var int|null
     */
    private ?int $fiatCurrencyId;

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
        $uniqueRule = Rule::unique(FiatCurrency::class);
        $statues    = CommonStatusEnum::values();

        if (!empty($this->fiatCurrencyId)) {
            $uniqueRule = $uniqueRule->ignore($this->fiatCurrencyId);
        }

        return [
            "name"   => ["required", "string", $uniqueRule],
            "symbol" => ["required", "string", "max:15"],
            "rate"   => ["nullable", "numeric"],
            "status" => ["required", "string", 'in:' . implode(',', $statues)],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->fiatCurrencyId = $this->route('fiat');
    }

}
