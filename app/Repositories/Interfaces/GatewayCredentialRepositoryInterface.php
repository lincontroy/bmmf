<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface GatewayCredentialRepositoryInterface extends BaseRepositoryInterface
{
    public function destroyCredential(int $gatewayId): bool;
}
