<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TxnReportRepositoryInterface extends BaseRepositoryInterface
{
    public function totalData(string $txnType): float;
    public function sumCurrentMonthData(string $txnType, $customerId): float;
    public function sumPreviousMonthData(string $txnType, $customerId): float;
    public function sumYearlyChartData(string $txnType, $customerId): array;
    public function historyChartData(string $tnxType, string $dataType): array;
    public function acceptCurrencyChartData(): ?object;
    public function latestTxnData(): array;
    public function recentTnxData(): ?object;
    public function customerRecentData($attributes = []): array;
}
