<?php

namespace App\Repositories\Eloquent;

use App\Enums\InvestDetailStatusEnum;
use App\Models\InvestmentDetail;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\InvestmentDetailsRepositoryInterface;
use Carbon\Carbon;

class InvestmentDetailsRepository extends BaseRepository implements InvestmentDetailsRepositoryInterface
{
    public function __construct(InvestmentDetail $model)
    {
        parent::__construct($model);
    }

    public function findInvestmentDetailsByNextInterestDate(): ?object
    {
        $nowTime = Carbon::now();

        return $this->model->where('status', InvestDetailStatusEnum::RUNNING->value)
            ->where("next_roi_at", "<=", $nowTime);
    }

    /**
     * change invest details status data
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function changeStatusByInvestmentId(int $id, array $attributes): bool
    {
        $detailsData = $this->model->where("investment_id", $id)->first();

        if (!$detailsData) {
            return false;
        }

        return $detailsData->update($attributes);
    }

}
