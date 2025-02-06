<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MerchantAcceptCoinRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find By Id with Accept Currency
     *
     * @param integer $id
     * @return object|null
     */
    public function findByIdWithAcceptCurrency(int $id): ?object;

    /**
     * destroy By Attributes
     *
     * @param array $attributes
     * @return boolean
     */
    public function destroyByAttributes(array $attributes): bool;

    /**
     *  destroy By merchant payment url id
     *
     * @param integer $merchant_payment_url_id
     * @return boolean
     */
    public function destroyByMerchantPaymentUrlId(int $merchant_payment_url_id): bool;
}
