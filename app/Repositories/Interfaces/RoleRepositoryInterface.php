<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find role with permissions
     *
     * @param integer $id
     * @return object|null
     */
    public function findWithPermissions(int $id): ?object;
}
