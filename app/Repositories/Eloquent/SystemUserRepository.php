<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Models\User;
use App\Repositories\Interfaces\SystemUsersRepositoryInterface;

class SystemUserRepository extends BaseRepository implements SystemUsersRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
