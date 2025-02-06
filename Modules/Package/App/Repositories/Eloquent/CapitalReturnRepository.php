<?php

namespace Modules\Package\App\Repositories\Eloquent;

use Carbon\Carbon;
use App\Models\CapitalReturn;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Package\App\Enums\CapitalReturnStatusEnum;
use Modules\Package\App\Repositories\Interfaces\CapitalReturnRepositoryInterface;

class CapitalReturnRepository extends BaseRepository implements CapitalReturnRepositoryInterface
{
    public function __construct(CapitalReturn $model)
    {
        parent::__construct($model);
    }

    public function findCapitalReturnByReturnAt(): ?object
    {
        $nowTime = Carbon::now();

        return $this->model->where('status', CapitalReturnStatusEnum::PENDING->value)
            ->where("return_at", "<=", $nowTime);
    }
}