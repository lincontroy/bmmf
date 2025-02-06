<?php

namespace Modules\Merchant\App\Services;

use Illuminate\Support\Arr;
use Modules\Merchant\App\Repositories\Interfaces\MerchantBalanceRepositoryInterface;

class MerchantBalanceService
{
    public function __construct(
        private MerchantBalanceRepositoryInterface $merchantBalanceRepository,
    ) {

    }

    /**
     * Fetch wallet balance by user Id and Currency Id
     * @param array $attributes
     * @return object|null
     */
    public function walletBalance(array $attributes): ?object
    {
        return $this->merchantBalanceRepository->findDoubleWhereFirst(
            'accept_currency_id',
            $attributes['currency_id'],
            'user_id', $attributes['user_id']
        );
    }

    /**
     * Balance deduct and others column add
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function balanceDeduct(array $attributes, int $id): bool
    {
        $walletManageData = $this->merchantBalanceRepository->find($id);

        foreach ($attributes as $key => $value) {

            if (isset($walletManageData->$key)) {

                if ($key == "amount") {
                    $updatedValues[$key] = $walletManageData->$key - $value;
                } else {
                    $updatedValues[$key] = $walletManageData->$key + $value;
                }

            }

        }

        return $this->merchantBalanceRepository->updateById($walletManageData->id, $updatedValues);
    }

    /**
     * Balance added and others column add
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function balanceAdd(array $attributes, int $id): bool
    {
        $walletManageData = $this->merchantBalanceRepository->find($id);

        foreach ($attributes as $key => $value) {

            if (isset($walletManageData->$key)) {

                if ($key == "amount") {
                    $updatedValues[$key] = $walletManageData->$key + $value;
                } else {
                    $updatedValues[$key] = $walletManageData->$key - $value;
                }

            }

        }

        return $this->merchantBalanceRepository->updateById($walletManageData->id, $updatedValues);
    }

    /**
     * Update wallet manage for user
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function reverseTxn(array $attributes): bool
    {
        $walletManageData = $this->merchantBalanceRepository->findDoubleWhereFirst(
            'accept_currency_id',
            $attributes['accept_currency_id'],
            'user_id',
            $attributes['user_id']
        );

        $filteredAttributes = Arr::except($attributes, ['user_id', 'accept_currency_id']);

        foreach ($filteredAttributes as $key => $value) {

            if (isset($walletManageData->$key)) {

                if ($key == "amount") {
                    $updatedValues[$key] = $walletManageData->$key + $value;
                } else {
                    $updatedValues[$key] = $walletManageData->$key - $value;
                }

            }

        }

        return $this->merchantBalanceRepository->updateById($walletManageData->id, $updatedValues);
    }

}
