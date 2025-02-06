<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Models\MerchantAcceptedCoin;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAcceptCoinRepositoryInterface;

class MerchantAcceptCoinRepository extends BaseRepository implements MerchantAcceptCoinRepositoryInterface
{
    /**
     * MerchantAcceptCoinRepository constructor
     *
     * @param MerchantAcceptedCoin $model
     */
    public function __construct(MerchantAcceptedCoin $model)
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

        if (isset($attributes['accept_currency_id'])) {
            $query = $query->where('accept_currency_id', $attributes['accept_currency_id']);
        }

        if (isset($attributes['merchant_payment_url_id'])) {
            $query = $query->where('merchant_payment_url_id', $attributes['merchant_payment_url_id']);
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
        return [
            'accept_currency_id'      => $attributes['accept_currency_id'],
            'merchant_payment_url_id' => $attributes['merchant_payment_url_id'],
        ];

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
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data      = $this->fillable($attributes);
        $findModel = $this->findByAttributes($data);

        if ($findModel) {
            return $findModel;
        }

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
    public function destroyByAttributes(array $attributes): bool
    {
        return $this->baseQuery($attributes)->delete();

    }

    /**
     * @inheritDoc
     */
    public function destroyByMerchantPaymentUrlId(int $merchant_payment_url_id): bool
    {
        return $this->model->newQuery()
            ->leftJoin('merchant_payment_infos', 'merchant_accepted_coins.id', '=', 'merchant_payment_infos.merchant_accepted_coin_id')
            ->whereNull('merchant_payment_infos.id')
            ->where('merchant_accepted_coins.merchant_payment_url_id', $merchant_payment_url_id)
            ->delete();

    }

    /**
     * @inheritDoc
     */
    public function findByIdWithAcceptCurrency(int $id): ?object
    {
        return $this->model->with('acceptCurrency')->find($id);
    }

}
