<?php

namespace App\Services\Customer;

use App\Repositories\Interfaces\UserLogRepositoryInterface;

class UserLogService
{
    /**
     * UserLogService constructor.
     *
     * @param UserLogRepositoryInterface $userLogRepository
     */
    public function __construct(
        protected UserLogRepositoryInterface $userLogRepository,
    ) {
    }

    public function create(array $data): object
    {
        return $this->userLogRepository->create($data);
    }
}
