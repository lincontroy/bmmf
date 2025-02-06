<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface CustomerVerifyRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Create customer verify doc
     *
     * @param array $attributes
     * @return object
     */
    public function createCustomerVerifyDoc(array $attributes): object;
}
