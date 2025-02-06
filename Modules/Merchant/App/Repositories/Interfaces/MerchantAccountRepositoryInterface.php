<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

interface MerchantAccountRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Query by attributes
     *
     * @param array $attributes
     * @return Builder
     */
    public function queryByAttributes(array $attributes): Builder;

    /**
     * Find by id with customer
     *
     * @param integer $id
     * @return object|null
     */
    public function findByIdWithCustomer(int $id): ?object;
}
