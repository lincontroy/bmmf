<?php

namespace Modules\Merchant\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface MerchantPaymentInfoRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Update Status by Id
     *
     * @param int $id
     * @param array $attributes
     * @return boolean
     */
    public function updateStatusAndAmountById($id, $attributes): bool;

}
