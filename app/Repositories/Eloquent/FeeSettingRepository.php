<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\FeeSetting;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\FeeSettingRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FeeSettingRepository extends BaseRepository implements FeeSettingRepositoryInterface
{
    /**
     * FeeSettingRepository constructor.
     *
     * @param  Expense  $model
     */
    public function __construct(FeeSetting $model)
    {
        parent::__construct($model);
    }

    /**
     * Fillable data for expense
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'level' => $attributes['level'],
            'fee'   => $attributes['fee'],
        ];

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'] ?? null;
        }

        return $data;
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attribute = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attribute['status'])) {
            $query = $query->where('status', $attribute['status']);
        }

        return $query;
    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): Collection
    {
        $query = $this->baseQuery($attributes);

        return $this->transformToCollection($query);
    }

    /**
     * Find all
     *
     * @return object|null
     */
    public function findAll(): ?object
    {
        return $this->baseQuery(["status" => StatusEnum::ACTIVE->value])->get();
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
    public function updateById(int $settingId, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return parent::updateById($settingId, $data);
    }

}
