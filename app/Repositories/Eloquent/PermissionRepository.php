<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function groups()
    {
        $permissions = Permission::cacheData();
        $groupData   = [];

        foreach ($permissions as $s) {
            $groupData[$s->group][] = $s;
        }

        return $groupData;
    }

}
