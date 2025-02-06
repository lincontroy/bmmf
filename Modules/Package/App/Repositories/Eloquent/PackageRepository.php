<?php

namespace Modules\Package\App\Repositories\Eloquent;

use App\Enums\AssetsFolderEnum;
use App\Enums\StatusEnum;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Models\Package;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;

class PackageRepository extends BaseRepository implements PackageRepositoryInterface
{
    public function __construct(Package $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param array $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): ?object
    {
        $query = $this->model->newQuery();

        if (isset($attributes['status']) && !empty($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        $query->get();

        return $query;
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function allActivePackages(array $attributes = []): object
    {
        return $this->model->where('status', StatusEnum::ACTIVE->value)->with('planTime')->get();
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function packagesPaginate(array $attributes = []): object
    {
        return $this->model->newQuery()->where('status', StatusEnum::ACTIVE->value)->with('planTime')->paginate(8);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data       = $this->fillable($attributes);
        $investType = $attributes['invest_type'];
        $returnType = $attributes['return_type'];

        if ($investType == '1') {
            $data['min_price'] = $attributes['min_price'];
            $data['max_price'] = $attributes['max_price'];
        } else {
            $data['min_price'] = $attributes['amount'];
        }

        if ($returnType == '2') {
            $data['repeat_time']  = $attributes['repeat_time'];
            $data['capital_back'] = CapitalBackEnum::YES->value;
        } else {
            $data['capital_back'] = CapitalBackEnum::NO->value;
        }

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
            'plan_time_id'  => $attributes['plan_time_id'],
            'name'          => $attributes['name'],
            'invest_type'   => $attributes['invest_type'],
            'interest_type' => $attributes['interest_type'],
            'interest'      => $attributes['interest'],
            'return_type'   => $attributes['return_type'],
            'image'         => $attributes['image'] ?? AssetsFolderEnum::PACKAGE_PLACEHOLDER->value,
        ];
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        /* echo "sdfdsf";
        dd($attributes)."ghghf"; */
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
