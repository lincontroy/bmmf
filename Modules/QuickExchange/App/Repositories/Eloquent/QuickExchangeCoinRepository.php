<?php

namespace Modules\QuickExchange\App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Repositories\Eloquent\BaseRepository;
use Modules\QuickExchange\App\Models\QuickExchangeCoin;
use Modules\QuickExchange\App\Repositories\Interfaces\QuickExchangeCoinRepositoryInterface;

class QuickExchangeCoinRepository extends BaseRepository implements QuickExchangeCoinRepositoryInterface
{
    public function __construct(QuickExchangeCoin $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all supported coins in quick exchange.
     * @return mixed
     */
    public function findSupportActiveCoins(): ?object
    {
        return $this->model->where('status', StatusEnum::ACTIVE->value)->orderBy('coin_position', 'asc')->get();
    }

    /**
     * Get quick exchange base coin
     * @return mixed
     */
    public function findBaseCoin(): ?object
    {
        return $this->model->where('status', StatusEnum::ACTIVE->value)
            ->where('base_currency', 1)->orderBy('coin_position', 'asc')->first();
    }

    public function updateCurrencyRate($attributes): bool
    {
        foreach ($attributes as $currency) {
            $this->model
                ->where('status', '1')
                ->where('symbol', $currency['symbol'])
                ->update(['market_rate' => $currency['quote']['USD']['price']]);
        }

        return true;
    }
}
