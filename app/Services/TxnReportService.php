<?php

namespace App\Services;

use App\Repositories\Interfaces\TxnReportRepositoryInterface;

class TxnReportService
{
    /**
     * Summary of __construct
     * @param \App\Repositories\Interfaces\TxnReportRepositoryInterface $txnReportRepository
     */
    public function __construct(
        protected TxnReportRepositoryInterface $txnReportRepository,
        private AcceptCurrencyService $acceptCurrencyService
    ) {
    }

    public function create(array $attributes): ?object
    {
        return $this->txnReportRepository->create($attributes);
    }

    public function report(string $txnType, $customerId = ''): object
    {
        $totalTxnAmount       = $this->txnReportRepository->totalData($txnType, $customerId);
        $currentMonthData     = $this->txnReportRepository->sumCurrentMonthData($txnType, $customerId);
        $previousMonthData    = $this->txnReportRepository->sumPreviousMonthData($txnType, $customerId);
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
    public function chartData(string $tnxType, $customerId = ''): object
    {
        $chartYearData = $this->txnReportRepository->sumYearlyChartData($tnxType, $customerId);
        return (object) [
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }

    /**
     * Summary of historyChartData
     * @param string $tnxType
     * @param string $dataType
     * @return object
     */
    public function historyChartData(string $tnxType, string $dataType): object
    {
        return (object) $this->txnReportRepository->historyChartData($tnxType, $dataType);
    }

    /**
     * Latest all transaction history
     *
     * @return void
     */
    public function recentTnxData(): ?object
    {
        return $this->txnReportRepository->recentTnxData();
    }

    /**
     * Latest transaction history
     *
     * @return void
     */
    public function latestTxnData(): array
    {
        return $this->txnReportRepository->latestTxnData();
    }

    /** Currency Chart Data
     * @return object
     */
    public function currencyChartData(): object
    {
        $chartData  = $this->txnReportRepository->acceptCurrencyChartData();
        $symbolData = $this->acceptCurrencyService->currencySymbolData($chartData);

        $chartDataArray = [];

        foreach ($chartData as $data) {
            $chartDataArray[] = $data->total_amount;
        }

        return (object) [
            'labels' => $symbolData,
            'values' => $chartDataArray,
        ];
    }

}
