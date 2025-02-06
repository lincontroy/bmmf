<?php

namespace Modules\QuickExchange\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

interface QuickExchangeRequestRepositoryInterface extends BaseRepositoryInterface
{
    public function findRecentTransaction(int $limit): ?object;
    public function findPaginateTransaction(array $attribute): ?object;

    /**
     * Quick Exchange Order Request Data table
     *
     * @param array $attributes
     * @return Builder
     */
    public function quickExchangeOrderRequestDataTable(array $attributes = []): Builder;
}
