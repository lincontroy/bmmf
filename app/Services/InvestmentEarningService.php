<?php

namespace App\Services;

use App\Repositories\Eloquent\InvestmentEarningRepository;

class InvestmentEarningService
{
    /**
     * InvestmentEarningService constructor.
     *
     * @param InvestmentEarningRepository $investmentEarningRepository
     */
    public function __construct(
        private InvestmentEarningRepository $investmentEarningRepository,
    ) {
    }
    public function report(string $userId): object
    {
        $totalEarnAmount       = $this->investmentEarningRepository->totalData($userId);
        $currentMonthData     = $this->investmentEarningRepository->sumCurrentMonthData();
        $previousMonthData    = $this->investmentEarningRepository->sumPreviousMonthData();
        $percentageDifference = $previousMonthData > 0 ? ($currentMonthData - $previousMonthData) / $previousMonthData * 100 :
            ($currentMonthData - $previousMonthData > 0 ? 100 : 0);
       
        return (object)[
            'totalEarnAmount'       => number_format($totalEarnAmount, 2, '.', ''),
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
        $chartYearData = $this->investmentEarningRepository->sumYearlyChartData($userId);
        return (object) [
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }

}
