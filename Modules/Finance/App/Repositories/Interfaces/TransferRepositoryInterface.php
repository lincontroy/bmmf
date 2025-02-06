<?php

namespace Modules\Finance\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TransferRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllReceived(array $attributes): ?object;
    public function getAllTransfer(array $attributes): ?object;
    public function transferDetails($id): ?object;
}
