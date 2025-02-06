<?php

namespace Modules\Package\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TeamBonusRepositoryInterface extends BaseRepositoryInterface
{
    public function updateByUserId(string $userId, array $attributes): bool;
    public function totalData($userId = '', $type): float;

    public function sumCurrentMonthData($userId = '', $type): float;

    public function sumPreviousMonthData($userId, $type): float;

    public function sumYearlyChartData($userId, $type): array;
}
