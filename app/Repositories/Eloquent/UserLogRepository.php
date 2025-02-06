<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\Customer;
use App\Models\UserLog;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\UserLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserLogRepository extends BaseRepository implements UserLogRepositoryInterface
{
    public function __construct(UserLog $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        return $this->model->create($attributes);
    }

}
