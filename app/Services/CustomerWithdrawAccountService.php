<?php

namespace App\Services;

use App\Repositories\Interfaces\WithdrawAccountRepositoryInterface;

class CustomerWithdrawAccountService
{
    /**
     * CustomerWithdrawAccountService constructor.
     *
     */
    public function __construct(
        protected WithdrawAccountRepositoryInterface $customerWithdrawAccountRepository
    ) {
    }

    public function allActive(array $attributes = []): ?object
    {
        return $this->customerWithdrawAccountRepository->allActive($attributes);
    }

    public function userWithdrawAccount(array $attributes = []): ?object
    {
        return $this->customerWithdrawAccountRepository->userWithdrawAccount($attributes);
    }
}
