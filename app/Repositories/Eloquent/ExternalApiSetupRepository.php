<?php

namespace App\Repositories\Eloquent;

use App\Models\ExternalApiSetup;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ExternalApiRepositoryInterface;

class ExternalApiSetupRepository extends BaseRepository implements ExternalApiRepositoryInterface
{
    public function __construct(ExternalApiSetup $model)
    {
        parent::__construct($model);
    }
}
