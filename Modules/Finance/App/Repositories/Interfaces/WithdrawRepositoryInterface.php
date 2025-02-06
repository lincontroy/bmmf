<?php

namespace Modules\Finance\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface WithdrawRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * get recent data
     *
     * @param array $attributes
     * @return object|null
     */
    public function recentData(array $attributes): ?object;
    public function getAll(array $attributes): ?object;
}
