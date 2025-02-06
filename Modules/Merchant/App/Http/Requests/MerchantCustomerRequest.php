<?php

namespace Modules\Merchant\App\Http\Requests;

use App\Traits\FormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Merchant\App\Models\MerchantCustomerInfo;

class MerchantCustomerRequest extends FormRequest
{
    use FormRequestTrait;

    /**
     * Article id
     *
     * @var int|null
     */
    private ?int $customerId;

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

        $uniqueRule = Rule::unique(MerchantCustomerInfo::class);

        if (!empty($this->customerId)) {
            $uniqueRule = $uniqueRule->ignore($this->customerId);
        }

        return [
            'first_name' => ['required', 'string', 'min:2', 'max:150'],
            'last_name'  => ['required', 'string', 'min:2', 'max:150'],
            'email'      => ['required', 'email', $uniqueRule],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->customerId = $this->route('customer');
    }

}
