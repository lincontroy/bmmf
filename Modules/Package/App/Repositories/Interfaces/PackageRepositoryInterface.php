<?php

namespace Modules\Package\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface PackageRepositoryInterface extends BaseRepositoryInterface
{
    public function packagesPaginate(array $attributes = []): object;
    public function allActivePackages(array $attributes = []): object;
}
