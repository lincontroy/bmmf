<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\PaymentGateway;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\PaymentGatewayRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class PaymentGatewayRepository extends BaseRepository implements PaymentGatewayRepositoryInterface
{
    public function __construct(PaymentGateway $model)
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

        if (isset($attributes['min_deposit'])) {
            $query = $query->where('min_deposit', $attributes['min_deposit']);
        }

        if (isset($attributes['max_deposit'])) {
            $query = $query->where('max_deposit', $attributes['max_deposit']);
        }

        if (isset($attributes['fee_percent'])) {
            $query = $query->where('fee_percent', $attributes['fee_percent']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    public function findAll(): ?object
    {
        return $this->model->where("status", StatusEnum::ACTIVE->value)->get();
    }

    /**
     * @inheritDoc
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->baseQuery($attributes)->with($relations)->first();
    }

}
