<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    /**
     * LanguageRepository constructor.
     *
     * @param Expense $model
     */
    public function __construct(Language $model)
    {
        parent::__construct($model);
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
     * Base query
     *
     * @param array $attributes
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
     * Fillable data for expense
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'name'   => $attributes['name'],
            'symbol' => $attributes['symbol'] ?? null,
            'logo'   => $attributes['logo'] ?? null,
        ];

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'] ?? null;
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $settingId, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        return parent::updateById($settingId, $data);
    }

    /**
     * @inheritDoc
     */
    public function destroyById(int $id): bool
    {
        return $this->model->where('id', $id)->forceDelete();
    }

}
