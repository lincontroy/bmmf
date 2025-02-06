<?php

namespace App\Services\Customer;

use App\Repositories\Interfaces\InvestmentEarningRepositoryInterface;
use App\Repositories\Interfaces\InvestmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class InvestmentRoiService
{
    /**
     * PackageService constructor.
     *
     */
    public function __construct(
        private InvestmentEarningRepositoryInterface $investmentEarningRepository,
    ) {
    }

    /**
     * get data by id
     * @param array $attributes
     * @return object
     */
    public function getAllInvestments(array $attributes): object
    {
        return $this->investmentEarningRepository->getAllInvestments($attributes);
    }

    public function report(): object
    {
        $totalTxnAmount       = $this->investmentEarningRepository->totalData();
        $currentMonthData     = $this->investmentEarningRepository->sumCurrentMonthData();
        $previousMonthData    = $this->investmentEarningRepository->sumPreviousMonthData();
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
    public function chartData(): object
    {
        $chartYearData = $this->investmentEarningRepository->sumYearlyChartData();

        return (object)[
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }

}
