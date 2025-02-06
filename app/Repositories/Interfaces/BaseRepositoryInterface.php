<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    public function find(int $id): ?object;
    public function findWhere(string $searchColumn, string $columnValue): ?object;
    public function first(): ?object;
    public function firstWhere(string $searchColumn, string $columnValue): ?object;
    public function all(): ?object;
    public function paginate(int $perPage = 15, array $columns = ["*"]): ?object;
    public function orderPaginate(array $attributes, array $relations = [], array $columns = ["*"]): ?object;
    public function delete(int $id): bool;
    public function deleteWhere(string $searchColumn, string $columnValue): bool;
    public function modelExists(string $searchColumn, string $columnValue): bool;
    public function count(): int;
    public function findLatest(): ?object;
    public function findLatestWhereFirst(
        string $searchColumn,
        string $columnValue
    ): ?object;
    public function findDoubleWhere(
        string $searchColumn,
        string $columnValue,
        string $searchColumn2,
        string $columnValue2
    ): ?object;
    public function findDoubleWhereFirst(
        string $searchColumn,
        string $columnValue,
        string $searchColumn2,
        string $columnValue2
    ): ?object;

    public function updateById(int $id, array $attributes): bool;
    public function create(array $attributes): object;

    /**
     * Find data by id or fail
     *
     * @param  int  $id
     * @param  array  $relations
     * @return object
     */
    public function findOrFail(int $id, array $relations = []): object;

    /**
     * Find data by attributes
     *
     * @param  array  $attributes
     * @param  array  $relations
     * @return object|null
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object;

    /**
     * Get data by attributes
     *
     * @param  array  $attributes
     * @param  array  $relations
     * @return object|null
     */
    public function getByAttributes(array $attributes = [], array $relations = []): ?object;

    /**
     * Delete data by id
     *
     * @param  int  $id
     * @return bool
     */
    public function destroyById(int $id): bool;

    public function whereCount(string $searchColumn, string $searchValue): int;

    public function doubleWhereCount(string $searchColumn, string $searchValue, string $searchSecondColumn, string $searchSecondValue): int;

    /**
     * Get a model new query builder.
     *
     * @param Builder|null $query
     * @return Builder
     */
    public function newQuery(?Builder $query = null): Builder;

}
