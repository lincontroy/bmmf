<?php

namespace Modules\Package\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface CapitalReturnRepositoryInterface extends BaseRepositoryInterface
{
    public function findCapitalReturnByReturnAt(): ?object;
}
