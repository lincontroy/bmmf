<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface UsersRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find user with roles
     *
     * @param integer $id
     * @return object|null
     */
    public function findWithRolesPermissions(int $id): ?object;

    /**
     * Find user with roles
     *
     * @param integer $id
     * @return object|null
     */
    public function findWithRoles(int $id): ?object;

    /**
     * Find user with permissions
     *
     * @param integer $id
     * @return object|null
     */
    public function findWithPermissions(int $id): ?object;

    public function updateAccountSetting(int $id, array $attributes): bool;

}
