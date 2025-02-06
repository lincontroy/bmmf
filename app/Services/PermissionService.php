<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService
{
    /**
     * PermissionService constructor.
     *
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository,
    ) {

    }

    /**
     * Fetch Permission Group
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function groups()
    {
        return $this->permissionRepository->groups();
    }

    /**
     * Fetch Permission Groups and Sub Groups
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function groupsAndSubgroups()
    {
        $groups = $this->permissionRepository->groups();

        $subGroupedData = [];

        foreach ($groups as $mainGroup => $items) {
            foreach ($items as $item) {
                // Split the name by dot
                $parts = explode('.', $item['name']);
                $subGroup = $parts[0];

                // Initialize the subgroup if it doesn't exist
                if (!isset($subGroupedData[$mainGroup][$subGroup])) {
                    $subGroupedData[$mainGroup][$subGroup] = [];
                }

                // Add the item to the appropriate subgroup
                $subGroupedData[$mainGroup][$subGroup][] = $item;
            }
        }

        return $subGroupedData;

    }


    /**
     * Fetch All
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function all()
    {
        return $this->permissionRepository->all();
    }

}
