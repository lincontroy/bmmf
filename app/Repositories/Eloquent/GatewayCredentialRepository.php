<?php

namespace App\Repositories\Eloquent;

use App\Models\PaymentGatewayCredential;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\GatewayCredentialRepositoryInterface;

class GatewayCredentialRepository extends BaseRepository implements GatewayCredentialRepositoryInterface
{
    public function __construct(PaymentGatewayCredential $model)
    {
        parent::__construct($model);
    }

    /**
     * Delete payment gateway credentials
     * @param int $gatewayId
     * @return bool
     */
    public function destroyCredential(int $gatewayId): bool
    {
        return $this->model->where('payment_gateway_id', $gatewayId)->delete();
    }
}