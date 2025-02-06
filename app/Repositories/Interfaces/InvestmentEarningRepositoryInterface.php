<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface InvestmentEarningRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * get recent data
     *
     * @param array $attributes
     * @return void
     */
    public function recentData(array $attributes): ?object;
}
