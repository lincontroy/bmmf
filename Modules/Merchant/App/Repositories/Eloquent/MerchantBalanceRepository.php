<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantBalance;
use Modules\Merchant\App\Repositories\Interfaces\MerchantBalanceRepositoryInterface;

class MerchantBalanceRepository extends BaseRepository implements MerchantBalanceRepositoryInterface
{
    /**
     * MerchantBalanceRepository constructor
     *
     * @param MerchantBalance $model
     */
    public function __construct(MerchantBalance $model)
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

        if (isset($attributes['id'])) {
            $query = $query->where('id', $attributes['id']);
        }

        if (isset($attributes['accept_currency_id'])) {
            $query = $query->where('accept_currency_id', $attributes['accept_currency_id']);
        }

        if (isset($attributes['symbol'])) {
            $query = $query->where('symbol', $attributes['symbol']);
        }

        if (isset($attributes['merchant_account_id'])) {
            $query = $query->where('merchant_account_id', $attributes['merchant_account_id']);
        }

        if (isset($attributes['user_id'])) {
            $query = $query->where('user_id', $attributes['user_id']);
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
            'amount'              => $attributes['amount'],
            'accept_currency_id'  => $attributes['accept_currency_id'],
            'merchant_account_id' => $attributes['merchant_account_id'],
        ];

        if (isset($attributes['user_id'])) {
            $data['user_id'] = $attributes['user_id'];
        }

        if (isset($attributes['symbol'])) {
            $data['symbol'] = $attributes['symbol'];
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
    public function createOrUpdateAmount(array $attributes): ?object
    {
        $merchantBalance = $this->baseQuery([
            'accept_currency_id'  => $attributes['accept_currency_id'],
            'merchant_account_id' => $attributes['merchant_account_id'],
        ])->first();

        if ($merchantBalance) {
            $this->baseQuery(['id' => $merchantBalance->id])->update([
                'amount' => ($merchantBalance->amount + $attributes['amount']),
            ]);

            return $this->baseQuery(['id' => $merchantBalance->id])->first();
        }

        $data = $this->fillable($attributes);
        return parent::create($data);
    }

}
