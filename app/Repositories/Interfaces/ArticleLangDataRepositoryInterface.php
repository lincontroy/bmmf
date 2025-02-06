<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface ArticleLangDataRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Update data by condition
     *
     * @param  array  $conditions
     * @return bool
     */
    public function deleteByCondition(array $conditions): bool;
}
