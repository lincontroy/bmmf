<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface AcceptCurrencyGatewayRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Delete accept currency gateway data
     * @param int $gatewayId
     * @return bool
     */
    public function destroyCurrencyGateway(int $gatewayId): bool;
}
