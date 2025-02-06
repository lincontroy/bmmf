<?php

namespace Modules\Finance\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Finance\App\Models\Deposit;
use Modules\Finance\App\Repositories\Interfaces\DepositRepositoryInterface;

class DepositRepository extends BaseRepository implements DepositRepositoryInterface
{
    public function __construct(Deposit $model)
    {
        parent::__construct($model);
    }

    /**
     * get credit details by deposit id
     *
     * @param array $attributes
     * @return void
     */
    public function getAll(array $attributes): ?object
    {
        return $this->model->newQuery()->where('customer_id', $attributes['customer_id'])->with('customerInfo')->orderBy('id', 'desc')->get();
    }

    /**
     * get recent data
     *
     * @param array $attributes
     * @return void
     */
    public function recentData(array $attributes): ?object
    {
        return $this->model->newQuery()
            ->where('customer_id', $attributes['customer_id'])
            ->limit($attributes['limit'])
            ->orderBy('id', 'desc')
            ->with(['customerInfo', 'currencyInfo'])
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        return parent::updateById(
            $id,
            $attributes
        );
    }

    /**
     * get credit details by deposit id
     *
     * @param int $id
     * @return void
     */
    public function creditDetails($id): ?object
    {

        return $this->model->newQuery()->where('id', $id)->with('customerInfo')->first();

    }

}
