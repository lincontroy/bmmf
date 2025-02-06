<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\WithdrawalAccount;
use App\Repositories\Interfaces\WithdrawAccountRepositoryInterface;

class WithdrawAccountRepository extends BaseRepository implements WithdrawAccountRepositoryInterface
{
    public function __construct(WithdrawalAccount $model)
    {
        parent::__construct($model);
    }

    public function allActive($attributes): ?object
    {
        $customerId = $attributes['customer_id'];

        return $this->model->where(function ($query) use ($customerId) {

            if (!empty($customerId)) {
                $query->where('customer_id', $customerId);
            }

        })->where('status', StatusEnum::ACTIVE->value)->with(['customer', 'currency', 'credentials'])->get();
    }

    public function userWithdrawAccount($attributes): ?object
    {
        $customerId       = $attributes['customer_id'];
        $paymentGatewayId = $attributes['payment_gateway_id'];

        return $this->model->where('customer_id', $customerId)
            ->where('payment_gateway_id', $paymentGatewayId)
            ->with(['customer', 'currency', 'credentials', 'gateway'])->first();
    }

    /**
     * Find withdrawal account
     * @param array $attributes
     * @return mixed
     */
    public function findAccount(array $attributes): ?object
    {
        return $this->model->where('customer_id', $attributes['customer_id'])
            ->where('payment_gateway_id', $attributes['payment_gateway_id'])
            ->where('accept_currency_id', $attributes['accept_currency_id'])
            ->first();
    }

}