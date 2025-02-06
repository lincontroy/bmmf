<?php

namespace Modules\Package\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Models\UserLevel;
use Modules\Package\App\Repositories\Interfaces\UserLevelRepositoryInterface;

class UserLevelRepository extends BaseRepository implements UserLevelRepositoryInterface
{
    public function __construct(UserLevel $model)
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
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        $investType = $attributes['invest_type'];
        $returnType = $attributes['return_type'];

        if ($investType == '2') {
            $data['min_price'] = $attributes['amount'];
        } else {
            $data['min_price'] = $attributes['min_price'];
            $data['max_price'] = $attributes['max_price'];
        }

        if ($returnType == '2') {
            $data['repeat_time']  = $attributes['repeat_time'];
            $data['capital_back'] = $attributes['capital_back'];
        } else {
            $data['repeat_time']  = null;
            $data['capital_back'] = CapitalBackEnum::NO->value;
        }

        return parent::updateById(
            $id,
            $data
        );
    }


}
