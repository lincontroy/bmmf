<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface CommissionSetupRepositoryInterface extends BaseRepositoryInterface
{
    public function updateByUserId(string $userId, array $attributes): bool;
    public function getCommission(array $attributes = []): ?object;
}
