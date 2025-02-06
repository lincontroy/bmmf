<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface PaymentGatewayRepositoryInterface extends BaseRepositoryInterface
{
    public function findAll(): ?object;

}