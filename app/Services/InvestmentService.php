<?php

namespace App\Services;

use App\Repositories\Interfaces\InvestmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class InvestmentService
{
    /**
     * PackageService constructor.
     *
     */
    public function __construct(
        private InvestmentRepositoryInterface $investmentRepository,
    ) {
    }

    /**
     * get data by id
     * @param array $attributes
     * @return object
     */
    public function getAllInvestments(array $attributes): object
    {
        return $this->investmentRepository->getAllInvestments($attributes);
    }

    public function report(string $userId = ''): object
    {
        $totalTxnAmount       = $this->investmentRepository->totalData($userId);
        $currentMonthData     = $this->investmentRepository->sumCurrentMonthData($userId);
        $previousMonthData    = $this->investmentRepository->sumPreviousMonthData($userId);
        $percentageDifference = $previousMonthData > 0 ? ($currentMonthData - $previousMonthData) / $previousMonthData * 100 :
            ($currentMonthData - $previousMonthData > 0 ? 100 : 0);

        return (object)[
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
    public function chartData(string $userId = ''): object
    {
        $chartYearData = $this->investmentRepository->sumYearlyChartData($userId);

        return (object)[
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }

    /**
     * Investment history chart data
     * @param string $dataType
     * @return object
     */
    public function historyChart(string $dataType): object
    {
        return (object)$this->investmentRepository->historyChartData($dataType);
    }

    public function investmentHistoryData(): object
    {
        return $this->investmentRepository->investmentHistoryData();
    }

    public function getLastInvestment()
    {
        return $this->investmentRepository->findLatest();
    }

    public function findById($id): object
    {
        return $this->investmentRepository->findOrFail($id, ['details', 'package']);
    }

    public function myPackages($attributes = []): object
    {
        $attributes['user_id'] = Auth::user()->user_id;

        return $this->investmentRepository->myPackages($attributes);
    }

    public function investmentReport(array $attributes = []): object
    {
        $userId               = Auth::user()->user_id;
        $totalTxnAmount       = $this->investmentRepository->totalData($userId);
        $currentMonthData     = $this->investmentRepository->sumCurrentMonthData($userId);
        $previousMonthData    = $this->investmentRepository->sumPreviousMonthData($userId);
        $percentageDifference = $previousMonthData > 0 ? ($currentMonthData - $previousMonthData) / $previousMonthData * 100 :
            ($currentMonthData - $previousMonthData > 0 ? 100 : 0);

        return (object)[
            'totalTxnAmount'       => number_format($totalTxnAmount, 2, '.', ''),
            'currentMonthData'     => number_format($currentMonthData, 2, '.', ''),
            'previousMonthData'    => number_format($previousMonthData, 2, '.', ''),
            'percentageDifference' => number_format($percentageDifference, 2, '.', ''),
        ];
    }
}
