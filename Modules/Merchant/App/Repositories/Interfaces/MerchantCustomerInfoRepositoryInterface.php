<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

interface MerchantCustomerInfoRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find data by uuid or fail
     *
     * @param  string  $uu_id
     * @return object|null
     */
    public function findByUuid(string $uu_id): ?object;

    /**
     * Find data by uuid with merchant account or fail
     *
     * @param  string  $uu_id
     * @return object|null
     */
    public function findByUuidWithMerchantAccount(string $uu_id): ?object;

    /**
     * Merchant Customer Info Table
     *
     * @param array $attributes
     * @return Builder
     */
    public function merchantCustomerInfoTable(array $attributes = []): Builder;

    /**
     * Merchant Customer Count
     *
     * @param array $attributes
     * @return Builder
     */
    public function merchantCustomerCount(array $attributes = []): int;

}
