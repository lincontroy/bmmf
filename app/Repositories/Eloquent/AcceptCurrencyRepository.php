<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\AcceptCurrency;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class AcceptCurrencyRepository extends BaseRepository implements AcceptCurrencyRepositoryInterface
{
    public function __construct(AcceptCurrency $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function allWithBalance(array $attributes = []): ?object
    {
        $userId               = $attributes['user_id'];
        $attributes['status'] = StatusEnum::ACTIVE->value;

        return $this->baseQuery($attributes)->with('getBalance', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    /**
     * @inheritDoc
     */
    public function allActive(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->where('status', StatusEnum::ACTIVE->value)->get();
    }

    /**
     * Base query
     *
     * @param array $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attributes['name'])) {
            $query = $query->where('name', $attributes['name']);
        }

        if (isset($attributes['symbol'])) {
            $query = $query->where('symbol', $attributes['symbol']);
        }
        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(array $attributes): ?object
    {
        return $this->model->where('status', StatusEnum::ACTIVE->value)
                           ->with('marchentAcceptCoinInfo')
                           ->paginate($attributes['perPage']);
    }

    /**
     * @inheritDoc
     */
    public function currencyChartSymbolData(object $chartData): array
    {
        return AcceptCurrency::whereIn('id', $chartData->pluck('accept_currency_id')->all())
                             ->pluck('symbol')->toArray();
    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->get();
    }

    public function updateCurrencyRate($attributes): bool
    {
        foreach ($attributes as $currency) {
            $this->model
                ->where('status', '1')
                ->where('symbol', $currency['symbol'])
                ->update(['rate' => $currency['quote']['USD']['price']]);
        }

        return true;
    }

    /**
     * Fillable data
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'name'   => $attributes['name'],
            'symbol' => $attributes['symbol'],
            'logo'   => $attributes['logo'] ?? null,
            'status' => $attributes['status'],
        ];

        if (isset($attributes['created_by'])) {
            $data['created_by'] = $attributes['created_by'];
        }

        if (isset($attributes['updated_by'])) {
            $data['updated_by'] = $attributes['updated_by'];
        }

        return $data;
    }

}
