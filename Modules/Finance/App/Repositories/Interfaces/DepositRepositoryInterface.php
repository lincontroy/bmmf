<?php

namespace Modules\Finance\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface DepositRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * get recent data
     *
     * @param array $attributes
     * @return object|null
     */
    public function recentData(array $attributes): ?object;
}
