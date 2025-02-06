<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MerchantBalanceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Create or Update Amount
     *
     * @param array $attributes
     * @return object|null
     */
    public function createOrUpdateAmount(array $attributes): ?object;
}
