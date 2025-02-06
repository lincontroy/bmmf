<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TxnFeeReportRepositoryInterface extends BaseRepositoryInterface
{
    public function totalData(string $txnType): float;
    public function sumCurrentMonthData(string $txnType): float;
    public function sumPreviousMonthData(string $txnType): float;
    public function sumYearlyChartData(string $txnType): array;
    public function recentTxnFeeData(): object;
}
