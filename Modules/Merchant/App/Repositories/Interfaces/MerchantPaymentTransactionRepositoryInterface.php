<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\App\Enums\MerchantPaymentTransactionStatusEnum;

interface MerchantPaymentTransactionRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Update Status by Id
     *
     * @param int $id
     * @param MerchantPaymentTransactionStatusEnum $status
     * @return boolean
     */
    public function updateStatusById($id, $status): bool;

    /**
     * Merchant Payment Transaction Table
     *
     * @param array $attributes
     * @return Builder
     */
    public function merchantPaymentTransactionTable(array $attributes = []): Builder;

    /**
     * Merchant Payment Transaction Count
     *
     * @param array $attributes
     * @return Builder
     */
    public function merchantPaymentTransactionCount(array $attributes = []): int;

    /**
     * Take Latest Merchant Payment Transaction
     *
     * @param array $attributes
     * @param integer $take
     * @return object|null
     */
    public function takeLatestTransactionByAttributes(array $attributes = [], int $take = 10): ?object;

}
