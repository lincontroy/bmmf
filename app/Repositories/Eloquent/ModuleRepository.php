<?php

namespace App\Repositories\Eloquent;

use App\Models\Module;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ModuleRepositoryInterface;

class ModuleRepository extends BaseRepository implements ModuleRepositoryInterface
{
    public function __construct(Module $model)
    {
        parent::__construct($model);
    }

}