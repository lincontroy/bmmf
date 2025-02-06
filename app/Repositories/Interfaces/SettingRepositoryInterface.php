<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface SettingRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find Setting with language
     *
     * @return object|null
     */
    public function findSettingWithLanguage(): ?object;
}
