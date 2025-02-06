<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantPaymentInfo;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentInfoRepositoryInterface;

class MerchantPaymentInfoRepository extends BaseRepository implements MerchantPaymentInfoRepositoryInterface
{
    /**
     * MerchantPaymentInfoRepository constructor
     *
     * @param MerchantPaymentInfo $model
     */
    public function __construct(MerchantPaymentInfo $model)
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

        if (isset($attributes['merchant_account_id'])) {
            $query = $query->where('merchant_account_id', $attributes['merchant_account_id']);
        }

        if (isset($attributes['merchant_customer_info_id'])) {
            $query = $query->where('merchant_customer_info_id', $attributes['merchant_customer_info_id']);
        }

        if (isset($attributes['merchant_accepted_coin_id'])) {
            $query = $query->where('merchant_accepted_coin_id', $attributes['merchant_accepted_coin_id']);
        }

        if (isset($attributes['payment_gateway_id'])) {
            $query = $query->where('payment_gateway_id', $attributes['payment_gateway_id']);
        }

        if (isset($attributes['merchant_payment_transaction_id'])) {
            $query = $query->where('merchant_payment_transaction_id', $attributes['merchant_payment_transaction_id']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * Fillable data
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'merchant_account_id'             => $attributes['merchant_account_id'],
            'merchant_customer_info_id'       => $attributes['merchant_customer_info_id'],
            'merchant_accepted_coin_id'       => $attributes['merchant_accepted_coin_id'],
            'payment_gateway_id'              => $attributes['payment_gateway_id'],
            'merchant_payment_transaction_id' => $attributes['merchant_payment_transaction_id'],
            'amount'                          => $attributes['amount'],
        ];

        if (isset($attributes['received_amount'])) {
            $data['received_amount'] = $attributes['received_amount'];
        }

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'];
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->get();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);
        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function updateStatusAndAmountById($id, $attributes): bool
    {
        $data = [
            'status'          => $attributes['status'],
            'received_amount' => $attributes['received_amount'] ?? 0,
        ];
        return parent::updateById($id, $data);
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
