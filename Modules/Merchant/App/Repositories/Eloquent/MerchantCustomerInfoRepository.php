<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantCustomerInfo;
use Modules\Merchant\App\Repositories\Interfaces\MerchantCustomerInfoRepositoryInterface;

class MerchantCustomerInfoRepository extends BaseRepository implements MerchantCustomerInfoRepositoryInterface
{
    /**
     * MerchantCustomerInfoRepository constructor
     *
     * @param MerchantCustomerInfo $model
     */
    public function __construct(MerchantCustomerInfo $model)
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

        if (isset($attributes['uuid'])) {
            $query = $query->where('uuid', $attributes['uuid']);
        }

        if (isset($attributes['email'])) {
            $query = $query->where('email', $attributes['email']);
        }

        if (isset($attributes['customer_id'])) {
            $query = $query->whereHas('merchantAccount', function ($qry) use ($attributes) {
                $qry->whereHas('customerInfo', function ($q) use ($attributes) {
                    $q->where('id', $attributes['customer_id']);
                });
            });
        }

        if (isset($attributes['user_id'])) {
            $query = $query->whereHas('merchantAccount', function ($qry) use ($attributes) {
                $qry->where('user_id', $attributes['user_id']);
            });
        }

        return $query;
    }

    /**
     * Fillable data
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'merchant_account_id' => $attributes['merchant_account_id'],
            'email'               => $attributes['email'],
            'first_name'          => $attributes['first_name'],
            'last_name'           => $attributes['last_name'],
        ];

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
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->first();
    }

    /**
     * @inheritDoc
     */
    public function findByUuid(string $uuid): ?object
    {
        return $this->baseQuery(['uuid' => $uuid])->first();
    }

    /**
     * @inheritDoc
     */
    public function findByUuidWithMerchantAccount(string $uuid): ?object
    {
        return $this->baseQuery(['uuid' => $uuid])->with('merchantAccount')->first();
    }

    /**
     * @inheritDoc
     */
    public function merchantCustomerInfoTable(array $attributes = []): Builder
    {
        return $this->baseQuery($attributes);
    }

    /**
     * @inheritDoc
     */
    public function merchantCustomerCount(array $attributes = []): int
    {
        return $this->baseQuery($attributes)->count();
    }

}
