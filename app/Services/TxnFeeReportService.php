<?php

namespace App\Services;

use App\Repositories\Interfaces\TxnFeeReportRepositoryInterface;

class TxnFeeReportService
{
    /**
     * Summary of __construct
     * @param TxnFeeReportRepositoryInterface $txnReportRepository
     */
    public function __construct(
        protected TxnFeeReportRepositoryInterface $txnFeeReportRepository
    ) {
    }

    public function create(array $attributes): ?object
    {
        return $this->txnFeeReportRepository->create($attributes);
    }

    public function report(string $txnType): object
    {
        $totalTxnAmount       = $this->txnFeeReportRepository->totalData($txnType);
        $currentMonthData     = $this->txnFeeReportRepository->sumCurrentMonthData($txnType);
        $previousMonthData    = $this->txnFeeReportRepository->sumPreviousMonthData($txnType);
        $percentageDifference = $previousMonthData > 0 ? ($currentMonthData - $previousMonthData) / $previousMonthData * 100 :
        ($currentMonthData - $previousMonthData > 0 ? 100 : 0);

        return (object) [
            'totalTxnAmount'       => number_format($totalTxnAmount, 2, '.', ''),
            'currentMonthData'     => number_format($currentMonthData, 2, '.', ''),
            'previousMonthData'    => number_format($previousMonthData, 2, '.', ''),
            'percentageDifference' => number_format($percentageDifference, 2, '.', ''),
        ];
    }

    /**
     * Fetch yearly transaction chart data
     * @return object
     */
    public function chartData(string $tnxType): object
    {
        $chartYearData = $this->txnFeeReportRepository->sumYearlyChartData($tnxType);

        return (object) [
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }

    /**
     * Last ten transaction fee history
     *
     * @return void
     */
    public function recentFeeData(): ?object
    {
        return $this->txnFeeReportRepository->recentTxnFeeData();
    }

}
