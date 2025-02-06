<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface WalletManageRepositoryInterface extends BaseRepositoryInterface
{
    public function topInvestors(): ?object;

    public function getBalance(array $attributes = []): float;

    public function updateByUserId(string $userId, array $attributes): bool;
}
