<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface PaymentRequestRepositoryInterface extends BaseRepositoryInterface
{
    public function findPendingTx(array $attributes): ?object;
}
