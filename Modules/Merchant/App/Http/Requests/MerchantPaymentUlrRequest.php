<?php

namespace Modules\Merchant\App\Http\Requests;

use App\Models\AcceptCurrency;
use App\Models\FiatCurrency;
use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Merchant\App\Enums\MerchantPaymentUlrPaymentTypeEnum;
use Modules\Merchant\App\Models\MerchantPaymentUrl;
use Modules\Merchant\App\Rules\GreaterThanNow;

class MerchantPaymentUlrRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Article id
     *
     * @var int|null
     */
    private ?int $paymentUrlId;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        $merchantPaymentUlrPaymentTypes = MerchantPaymentUlrPaymentTypeEnum::values();

        $uniqueRule = Rule::unique(MerchantPaymentUrl::class);

        if (!empty($this->paymentUrlId)) {
            $uniqueRule = $uniqueRule->ignore($this->paymentUrlId);
        }

        return [
            'title'              => ['required', 'string', 'min:2', 'max:150'],
            'description'        => ['required', 'string'],
            'amount'             => ['required', 'numeric'],
            'fiat_currency_id'   => ['required', 'integer', Rule::exists(FiatCurrency::class, 'id')],
            'accept_currency_id' => ['nullable', 'array', Rule::exists(AcceptCurrency::class, 'id')],
            'duration'           => ['nullable', 'date', 'after:now'],

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
            'calback_url' => 'redirect',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->paymentUrlId = $this->route('payment_url');
    }

}
