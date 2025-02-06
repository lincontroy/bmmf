<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ArticleDataRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Update data by condition
     *
     * @param  array  $conditions
     * @param  array  $attributes
     * @return bool
     */
    public function updateByCondition(array $conditions, array $attributes): bool;

    /**
     * Update data by condition
     *
     * @param  array  $conditions
     * @return bool
     */
    public function deleteByCondition(array $conditions): bool;
}
