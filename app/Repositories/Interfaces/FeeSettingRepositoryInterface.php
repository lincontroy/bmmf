<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface FeeSettingRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll(): ?object;

}
