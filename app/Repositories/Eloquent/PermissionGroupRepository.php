<?php

namespace App\Repositories\Eloquent;

use App\Models\PermissionGroup;
use App\Repositories\Interfaces\PermissionGroupRepositoryInterface;

class PermissionGroupRepository extends BaseRepository implements PermissionGroupRepositoryInterface
{
    public function __construct(PermissionGroup $model)
    {
        parent::__construct($model);
    }
}
