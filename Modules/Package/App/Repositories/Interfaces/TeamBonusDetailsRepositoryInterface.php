<?php

namespace Modules\Package\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TeamBonusDetailsRepositoryInterface extends BaseRepositoryInterface
{
    public function updateByUserId(string $userId, array $attributes): object;
}
