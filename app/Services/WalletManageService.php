<?php

namespace App\Services;

use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use Illuminate\Support\Arr;

class WalletManageService
{
    /**
     * WalletManageService constructor.
     * @param \App\Repositories\Interfaces\WalletManageRepositoryInterface $walletManageRepository
     */
    public function __construct(
        protected WalletManageRepositoryInterface $walletManageRepository
    ) {
    }

    public function create(array $attributes): ?object
    {
        $walletManageData = $this->walletManageRepository->findDoubleWhereFirst(
            'accept_currency_id',
            $attributes['accept_currency_id'],
            'user_id',
            $attributes['user_id']
        );

        if ($walletManageData) {
            $filteredAttributes = Arr::except($attributes, ['user_id', 'accept_currency_id']);
            $this->updateWallet($filteredAttributes, $walletManageData->id);
        } else {
            $walletManageData = $this->createWallet($attributes);
        }

        return $walletManageData;
    }

    /**
     * Create Wallet Mange for user
     * @param array $attributes
     * @return object|null
     */
    public function createWallet(array $attributes): ?object
    {

        if (empty($attributes['user_id']) || empty($attributes['accept_currency_id'])) {
            return null;
        }

        return $this->walletManageRepository->create($attributes);
    }

    /**
     * Update wallet manage for user
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function updateWallet(array $attributes, int $id): bool
    {
        $walletManageData = $this->walletManageRepository->find($id);

        foreach ($attributes as $key => $value) {

            if (isset($walletManageData->$key)) {
                $updatedValues[$key] = $walletManageData->$key + $value;
            }

        }

        return $this->walletManageRepository->updateById($walletManageData->id, $updatedValues);
    }

    /**
     * Update wallet manage for user
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function reverseTxn(array $attributes): bool
    {
        $walletManageData = $this->walletManageRepository->findDoubleWhereFirst(
            'accept_currency_id',
            $attributes['accept_currency_id'],
            'user_id',
            $attributes['user_id']
        );

        $filteredAttributes = Arr::except($attributes, ['user_id', 'accept_currency_id']);

        foreach ($filteredAttributes as $key => $value) {

            if (isset($walletManageData->$key)) {

                if ($key == "balance") {
                    $updatedValues[$key] = $walletManageData->$key + $value;
                } else {
                    $updatedValues[$key] = $walletManageData->$key - $value;
                }

            }

        }

        return $this->walletManageRepository->updateById($walletManageData->id, $updatedValues);
    }

    /**
     * Update wallet manage for user
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function updateUserWallet(array $attributes, int $id): bool
    {
        return $this->walletManageRepository->updateById($id, $attributes);
    }

    /**
     * Balance deduct and others column add
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function balanceDeduct(array $attributes, int $id): bool
    {
        $walletManageData = $this->walletManageRepository->find($id);

        foreach ($attributes as $key => $value) {

            if (isset($walletManageData->$key)) {

                if ($key == "balance") {
                    $updatedValues[$key] = $walletManageData->$key - $value;
                } else {
                    $updatedValues[$key] = $walletManageData->$key + $value;
                }

            }

        }

        return $this->walletManageRepository->updateById($walletManageData->id, $updatedValues);
    }

    /**
     * Freeze Balance Deduct and other column added
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function freezeBalanceDeduct(array $attributes, int $id): bool
    {
        $walletManageData = $this->walletManageRepository->find($id);

        foreach ($attributes as $key => $value) {

            if (isset($walletManageData->$key)) {

                if ($key == "freeze_balance") {
                    $updatedValues[$key] = $walletManageData->$key - $value;
                } else {
                    $updatedValues[$key] = $walletManageData->$key + $value;
                }

            }

        }

        return $this->walletManageRepository->updateById($walletManageData->id, $updatedValues);
    }

    /**
     * Fetch wallet balance by user Id and Currency Id
     * @param array $attributes
     * @return object|null
     */
    public function walletBalance(array $attributes): ?object
    {
        return $this->btcBalance($attributes['currency_id'], $attributes['user_id']);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function btcBalance(int $id, string $userId = ''): ?object
    {
        return $this->walletManageRepository->findDoubleWhereFirst('accept_currency_id', $id, 'user_id', $userId);
    }
}
