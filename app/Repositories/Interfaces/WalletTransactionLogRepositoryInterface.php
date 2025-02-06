<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface WalletTransactionLogRepositoryInterface extends BaseRepositoryInterface
{
    public function userTransactionLogs(array $attributes):  ?object;
}
