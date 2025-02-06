<?php

namespace Modules\QuickExchange\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\QuickExchange\App\Models\QuickExchangeRequest;
use Modules\QuickExchange\App\Repositories\Interfaces\QuickExchangeRequestRepositoryInterface;

class QuickExchangeRequestRepository extends BaseRepository implements QuickExchangeRequestRepositoryInterface
{
    public function __construct(QuickExchangeRequest $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param array $attributes
     * @return Builder
     */
    private function baseQuery(array $attribute = []): Builder
    {
        $query = $this->model->newQuery();

        if (!empty($attribute['user_id'])) {
            $query = $query->where('user_id', $attribute['user_id']);
        }

        if (isset($attribute['status'])) {
            $query = $query->where('status', $attribute['status']);
        }

        return $query;
    }

    /**
     * Get Recent Transaction Data
     * @param int $limit
     * @return mixed
     */
    public function findRecentTransaction(int $limit): ?object
    {
        return $this->model->with(['sellCoin', 'buyCoin'])->orderBy('request_id', 'desc')->limit($limit)->get();
    }

    /**
     * Find Quick Exchange Paginate Transaction
     * @param array $attribute
     * @return mixed
     */
    public function findPaginateTransaction(array $attribute): ?object
    {
        return $this->model->with(['sellCoin', 'buyCoin'])->orderBy('request_id', 'desc')->paginate($attribute['perPage']);
    }

    /**
     * @inheritDoc
     */
    public function quickExchangeOrderRequestDataTable(array $attributes = []): Builder
    {
        return $this->baseQuery($attributes);
    }

}
