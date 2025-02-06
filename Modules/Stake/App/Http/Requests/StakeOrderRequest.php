<?php

namespace Modules\Stake\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Stake\App\Models\StakePlan;
use Modules\Stake\App\Models\StakeRateInfo;

class StakeOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "locked_amount"      => ["required", "numeric", "gt:0"],
            "stake_plan_id"      => ["required", "numeric", Rule::exists(StakePlan::class, 'id')],
            "stake_plan_rate_id" => ["required", "numeric", Rule::exists(StakeRateInfo::class, 'id')],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}