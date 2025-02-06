<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface UserLogRepositoryInterface extends BaseRepositoryInterface
{
    public function create(array $attributes): object;
}
