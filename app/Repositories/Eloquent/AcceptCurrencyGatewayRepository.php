<?php

namespace App\Repositories\Eloquent;

use App\Models\AcceptCurrencyGateway;
use App\Repositories\Interfaces\AcceptCurrencyGatewayRepositoryInterface;

class AcceptCurrencyGatewayRepository extends BaseRepository implements AcceptCurrencyGatewayRepositoryInterface
{
    public function __construct(AcceptCurrencyGateway $model)
    {
        parent::__construct($model);
    }

    /**
     * Summary of destroy
     * @param int $gatewayId
     * @return bool
     */
    public function destroyCurrencyGateway(int $gatewayId): bool
    {
        return $this->model->where('accept_currency_id', $gatewayId)->delete();
    }

}
