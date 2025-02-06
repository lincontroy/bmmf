<?php

namespace Modules\Package\App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Package\App\Models\PlanTime;
use Modules\Package\App\Repositories\Interfaces\PlanTimeRepositoryInterface;

class PlanTimeRepository extends BaseRepository implements PlanTimeRepositoryInterface
{
    public function __construct(PlanTime $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);

        $data['status'] = StatusEnum::ACTIVE->value;

        return parent::create($data);
    }

    /**
     * Prepare data for package
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        return [
            'name_' => $attributes['name_'],
            'hours_' => $attributes['hours_'],
            'created_by' => $attributes['created_by'],
        ];
    }

}
