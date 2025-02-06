<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TeamMemberRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll(): ?object;

}