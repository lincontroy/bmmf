<?php

namespace Modules\QuickExchange\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface QuickExchangeCoinRepositoryInterface extends BaseRepositoryInterface
{
    public function findSupportActiveCoins(): ?object;
    public function findBaseCoin(): ?object;
    public function updateCurrencyRate($attributes): bool;
}
