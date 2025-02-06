<?php

namespace App\Repositories\Eloquent;

use App\Models\FiatCurrency;
use App\Repositories\Interfaces\FiatCurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class FiatCurrencyRepository extends BaseRepository implements FiatCurrencyRepositoryInterface
{
    /**
     * FiatCurrencyRepository of constructor
     *
     * @param FiatCurrency $model
     */
    public function __construct(FiatCurrency $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attributes['name'])) {
            $query = $query->where('name', $attributes['name']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * Fillable data
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'name'   => $attributes['name'],
            'symbol' => $attributes['symbol'],
            'logo'   => $attributes['logo'] ?? null,
            'rate'   => $attributes['rate'] ?? null,
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

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->get();
    }

    /**
     * @inheritDoc
     */
    public function first(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);
        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        return parent::updateById($id, $data);
    }

}
