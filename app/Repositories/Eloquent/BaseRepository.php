<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    public $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Find model by primary key
     * @param int $id
     * @return mixed
     */
    public function first(): ?object
    {
        return $this->model->first();
    }

    /**
     * Find model by primary key
     * @param int $id
     * @return mixed
     */
    public function find(int $id): ?object
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail(int $id, array $relations = []): object
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->model->with($relations)->where($attributes)->first();
    }

    /**
     * @inheritDoc
     */
    public function getByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->model->with($relations)->where($attributes)->get();
    }

    /**
     * @inheritDoc
     */
    public function destroyById(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Find Model By One column search
     * @param string $searchColumn
     * @param string $columnValue
     * @return mixed
     */
    public function findWhere(string $searchColumn, string $columnValue): ?object
    {
        return $this->model->where($searchColumn, $columnValue)->get();
    }

    /**
     * Find Model and Get First Model by one column search
     * @param string $searchColumn
     * @param string $columnValue
     * @return mixed
     */
    public function firstWhere(string $searchColumn, string $columnValue): ?object
    {
        return $this->model->where($searchColumn, $columnValue)->first();
    }

    /**
     * Retrieve all model
     * @return object|null
     */
    public function all(): ?object
    {
        return $this->model->all();
    }

    /**
     * Retrieve model by paginate
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 25, array $columns = ["*"]): ?object
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Retrieve model by relation with order by paginate
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function orderPaginate(
        array $attributes,
        array $relations = [],
        array $columns = ["*"]
    ): ?object {
        $perPage = $attributes['perPage'] ?? 10;

        return $this->model->when(isset($attributes['searchColumn']), function ($query) use ($attributes) {
            return $query->where($attributes['searchColumn'], $attributes['searchColumnValue']);
        })
            ->with($relations)
            ->orderBy($attributes['orderByColumn'], $attributes['order'])
            ->paginate($perPage, $columns, 'page', $attributes['page']);
    }

    /**
     * Delete model by primary key
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $findModel = $this->find($id);
        return $findModel->delete();
    }

    /**
     * Delete model by one column search
     * @param string $searchColumn
     * @param string $columnValue
     * @return bool
     */
    public function deleteWhere(string $searchColumn, string $columnValue): bool
    {
        $findModel = $this->findWhere($searchColumn, $columnValue);

        if (!$findModel) {
            return false;
        }

        foreach ($findModel as $model) {
            $model->delete();
        }

        return true;
    }

    /**
     * Check model is exists or not
     * @param string $searchColumn
     * @param string $columnValue
     * @return bool
     */
    public function modelExists(string $searchColumn, string $columnValue): bool
    {
        return $this->model->where($searchColumn, $columnValue)->exists();
    }

    /**
     * Get model total count
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Get model count by search column
     * @return int
     */
    public function whereCount(string $searchColumn, string $searchValue): int
    {
        return $this->model->where($searchColumn, $searchValue)->count();
    }

    /**
     * Get model count by search column
     * @return int
     */
    public function doubleWhereCount(string $searchColumn, string $searchValue, string $searchSecondColumn, string $searchSecondValue): int
    {
        return $this->model->where($searchColumn, $searchValue)->where($searchSecondColumn, $searchSecondValue)->count();
    }

    /**
     * Summary of findLatest
     * @return mixed
     */
    public function findLatest(): ?object
    {
        return $this->model->latest("created_at")->first();
    }

    /**
     * Summary of findLatest
     * @return mixed
     */
    public function findLatestWhereFirst(
        string $searchColumn,
        string $columnValue
    ): ?object {
        return $this->model->where($searchColumn, $columnValue)
            ->latest("created_at")->first();
    }

    /**
     * Find Model By Two column search
     * @param string $searchColumn
     * @param string $columnValue
     * @return mixed
     */
    public function findDoubleWhere(
        string $searchColumn,
        string $columnValue,
        string $searchColumn2,
        string $columnValue2
    ): ?object {
        return $this->model->where($searchColumn, $columnValue)->where($searchColumn2, $columnValue2)->get();
    }

    /**
     * Find Model By Two column search
     * @param string $searchColumn
     * @param string $columnValue
     * @return mixed
     */
    public function findDoubleWhereFirst(
        string $searchColumn,
        string $columnValue,
        string $searchColumn2,
        string $columnValue2
    ): ?object {
        return $this->model->where($searchColumn, $columnValue)->where($searchColumn2, $columnValue2)->first();
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->find($id);
        return $data->update($attributes);
    }

    /**
     * Insert Data
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        return $this->model->create($attributes);
    }

    /**
     * Prepare collection & transform each model to array
     *
     * @param  Builder  $query
     * @return Collection
     */
    protected function transformToCollection(Builder $query): Collection
    {
        return collect($query->get());
    }

    /**
     * @inheritDoc
     */
    public function newQuery(?Builder $query = null): Builder
    {

        if ($query instanceof Builder) {
            return $query->newQuery();
        }

        return $this->model->newQuery();
    }

}