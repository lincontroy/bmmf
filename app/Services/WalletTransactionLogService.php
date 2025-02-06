<?php

namespace App\Services;

use App\Repositories\Interfaces\WalletTransactionLogRepositoryInterface;

class WalletTransactionLogService
{
    /**
     * WalletTransactionLogService constructor.
     *
     * @param WalletTransactionLogRepositoryInterface $walletTransactionLogRepository
     */
    public function __construct(
        protected WalletTransactionLogRepositoryInterface $walletTransactionLogRepository
    ) {
    }

    /**
     * Create Wallet Transaction Log
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): ?object
    {
        return $this->walletTransactionLogRepository->create($attributes);
    }

    /**
     * User Transaction Logs
     *
     * @param array $attributes
     * @return object
     */
    public function userTransactionLogs(array $attributes = []): ?object
    {
        return $this->walletTransactionLogRepository->userTransactionLogs($attributes);
    }

}
