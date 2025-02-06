<?php

namespace Modules\B2xloan\App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Modules\B2xloan\App\Models\B2xLoanPackage;
use Modules\B2xloan\App\Repositories\Interfaces\PackageRepositoryInterface;

class PackageRepository extends BaseRepository implements PackageRepositoryInterface
{
    public function __construct(B2xLoanPackage $model)
    {
        parent::__construct($model);
    }

    public function activeALl(): ?object
    {
        return $this->model->newquery()->where('status', StatusEnum::ACTIVE->value)->get();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data               = $this->fillable($attributes);
        $data['created_by'] = Auth::id();

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
            'no_of_month'      => $attributes['no_of_month'],
            'interest_percent' => $attributes['interest_percent'],
            'status'           => $attributes['status'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);
        return parent::updateById(
            $id,
            $data
        );
    }

}
