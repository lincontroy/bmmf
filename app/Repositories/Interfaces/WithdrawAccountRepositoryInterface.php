<?php

namespace App\Repositories\Interfaces;

interface WithdrawAccountRepositoryInterface extends BaseRepositoryInterface
{
    public function allActive($attributes): ?object;
    public function userWithdrawAccount($attributes): ?object;
    public function findAccount(array $attributes): ?object;
}
