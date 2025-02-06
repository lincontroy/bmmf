<?php

namespace Modules\B2xloan\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Enums\B2xLoanWithdrawStatusEnum;
use Modules\B2xloan\App\Models\B2xLoan;
use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepositoryInterface;

class B2xLoanRepository extends BaseRepository implements B2xLoanRepositoryInterface
{
    public function __construct(B2xLoan $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        return parent::updateById(
            $id,
            $attributes
        );
    }

    public function pendingAndSuccessLoanAmount(array $attributes = [])
    {
        return $this->model
            ->whereIn('status', [B2xLoanStatusEnum::APPROVED->value, B2xLoanWithdrawStatusEnum::PENDING->value])
            ->sum('hold_btc_amount');
    }

    public function create($attributes): object
    {
        $attributes['status']          = B2xLoanStatusEnum::PENDING->value;
        $attributes['withdraw_status'] = B2xLoanWithdrawStatusEnum::NOT_SUBMIT->value;

        return parent::create($attributes);
    }


}
