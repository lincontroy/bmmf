<?php

namespace Modules\Package\App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Models\TeamBonusDetails;
use Modules\Package\App\Repositories\Interfaces\TeamBonusDetailsRepositoryInterface;

class TeamBonusDetailsRepository extends BaseRepository implements TeamBonusDetailsRepositoryInterface
{
    public function __construct(TeamBonusDetails $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        return parent::create($attributes);
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function updateByUserId(string $userId, array $attributes): object
    {
        return $this->model->where('user_id', $userId)->update($attributes);
    }

}
