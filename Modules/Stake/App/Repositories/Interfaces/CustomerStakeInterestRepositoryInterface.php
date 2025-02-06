<?php

namespace Modules\Stake\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface CustomerStakeInterestRepositoryInterface extends BaseRepositoryInterface
{
    public function findRedeemedStake(): ?object;
}
