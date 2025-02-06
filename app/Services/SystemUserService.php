<?php

namespace App\Services;

use App\Enums\ActivityMessages\ClientUser\UserActivityEnum;
use App\Enums\ClientUserFilterEnum;
use App\Enums\ClientUserStatusEnum;
use App\Enums\ClientUserTypeEnum;
use App\Enums\SubscriptionEnum;
use App\Events\ClientUserActivated;
use App\Exceptions\DependencyException;
use App\Models\ClientUser;
use App\Repositories\Interfaces\SystemUsersRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class SystemUserService
{
    /**
     * SystemUserService constructor.
     *
     * @param SystemUsersRepositoryInterface $systemUserRepository
     */
    public function __construct(
        private SystemUsersRepositoryInterface $systemUserRepository,
    )
    {
        
    }
}
