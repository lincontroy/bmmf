<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MessageUserRepositoryInterface extends BaseRepositoryInterface
{
    public function createUser(array $data);
    public function setStatus(int $messengerId): bool;
}
