<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantPaymentTransaction;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentTransactionRepositoryInterface;

class MerchantPaymentTransactionRepository extends BaseRepository implements MerchantPaymentTransactionRepositoryInterface
{
    /**
     * MerchantPaymentTransactionRepository constructor
     *
     * @param MerchantPaymentTransaction $model
     */
    public function __construct(MerchantPaymentTransaction $model)
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

        if (isset($attributes['transaction_hash'])) {
            $query = $query->where('transaction_hash', $attributes['transaction_hash']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        if (isset($attributes['user_id'])) {
            $query = $query->whereHas('merchantPaymentInfo', function ($qry) use ($attributes) {
                $qry = $qry->whereHas('merchantAccount', function ($qy) use ($attributes) {
                    $qy->where('user_id', $attributes['user_id']);
                });
            });
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
            'payment_gateway_id' => $attributes['payment_gateway_id'],
            'transaction_hash'   => $attributes['transaction_hash'] ?? null,
            'amount'             => $attributes['amount'],
            'data'               => $attributes['data'],
        ];

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
    public function updateStatusById($id, $status): bool
    {
        $data = ['status' => $status];
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

    /**
     * @inheritDoc
     */
    public function merchantPaymentTransactionTable(array $attributes = []): Builder
    {
        return $this->baseQuery($attributes)->with([
            'merchantPaymentInfo.merchantCustomerInfo',
            'merchantPaymentInfo.merchantAcceptedCoin.acceptCurrency',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function merchantPaymentTransactionCount(array $attributes = []): int
    {
        return $this->baseQuery($attributes)->count();
    }

    /**
     * @inheritDoc
     */
    public function takeLatestTransactionByAttributes(array $attributes = [], int $take = 10): ?object
    {
        return $this->baseQuery($attributes)->with([
            'merchantPaymentInfo.merchantCustomerInfo',
            'merchantPaymentInfo.merchantAcceptedCoin.acceptCurrency',
        ])->take($take)->latest()->get();
    }

}
