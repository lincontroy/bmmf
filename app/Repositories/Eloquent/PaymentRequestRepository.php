<?php

namespace App\Repositories\Eloquent;

use App\Enums\PaymentRequestStatusEnum;
use App\Models\PaymentRequest;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\PaymentRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class PaymentRequestRepository extends BaseRepository implements PaymentRequestRepositoryInterface
{
    public function __construct(PaymentRequest $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attributes['payment_gateway_id'])) {
            $query = $query->where('payment_gateway_id', $attributes['payment_gateway_id']);
        }
        if (isset($attributes['merchant_payment_url_id'])) {
            $query = $query->where('merchant_payment_url_id', $attributes['merchant_payment_url_id']);
        }

        if (isset($attributes['txn_type'])) {
            $query = $query->where('txn_type', $attributes['txn_type']);
        }

        if (isset($attributes['txn_id'])) {
            $query = $query->where('txn_id', $attributes['txn_id']);
        }

        if (isset($attributes['txn_token'])) {
            $query = $query->where('txn_token', $attributes['txn_token']);
        }

        if (isset($attributes['currency'])) {
            $query = $query->where('currency', $attributes['currency']);
        }

        if (isset($attributes['tx_status'])) {
            $query = $query->where('tx_status', $attributes['tx_status']);
        }

        return $query;
    }

    /**
     * Find Transaction Data
     * @param array $attributes
     * @return mixed
     */
    public function findPendingTx(array $attributes): ?object
    {
        return $this->model->where('payment_gateway_id', $attributes['gatewayId'])
            ->where('user', $attributes['user'])->where('currency', $attributes['currency'])
            ->where('usd_value', $attributes['amount'])->where('txn_type', $attributes['txnType'])
            ->where('tx_status', PaymentRequestStatusEnum::PENDING->value)->first();
    }

    /**
     * @inheritDoc
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->first();
    }

    /**
     * @inheritDoc
     */
    public function getByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->get();
    }

}
