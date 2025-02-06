<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface LanguageRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll(): ?object;

}