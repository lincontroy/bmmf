<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionGroupRepositoryInterface;

class PermissionGroupService
{
    /**
     * PermissionGroupService constructor.
     *
     * @param PermissionGroupRepositoryInterface $permissionGroupRepository
     */
    public function __construct(
        private PermissionGroupRepositoryInterface $permissionGroupRepository,
    )
    {
        
    }
}
