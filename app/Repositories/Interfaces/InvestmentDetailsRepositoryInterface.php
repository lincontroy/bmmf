<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface InvestmentDetailsRepositoryInterface extends BaseRepositoryInterface
{
    public function findInvestmentDetailsByNextInterestDate(): ?object;
    public function changeStatusByInvestmentId(int $id, array $attributes): bool;
}