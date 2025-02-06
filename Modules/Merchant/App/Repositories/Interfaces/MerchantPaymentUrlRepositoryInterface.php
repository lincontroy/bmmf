<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

interface MerchantPaymentUrlRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * Merchant Payment Url Table
     *
     * @param array $attributes
     * @return Builder
     */
    public function merchantPaymentUrlTable(array $attributes = []): Builder;

    /**
     * Find data by id with currency or fail
     *
     * @param  int  $id
     * @return object
     */
    public function findWithCurrency(int $id): object;

    /**
     * Find data by uu_id with currency or fail
     *
     * @param  string  $uu_id
     * @return object|null
     */
    public function findByUuidWithCurrency(string $uu_id): ?object;

    /**
     * Find by uuid with Merchant Accept Coin
     *
     * @param string $uu_id
     * @param integer|null $accept_currency_id
     * @return object|null
     */
    public function findByUuidWithMerchantAcceptCoin(string $uu_id, ?int $accept_currency_id): ?object;

    /**
     * Update By current time
     *
     * @return boolean
     */
    public function updateByCurrentTime(): bool;

}
