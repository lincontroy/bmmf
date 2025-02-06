<?php

namespace App\Repositories\Eloquent;

use App\Models\TxnFeeReport;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\TxnFeeReportRepositoryInterface;
use Carbon\Carbon;

class TxnFeeReportRepository extends BaseRepository implements TxnFeeReportRepositoryInterface
{
    public function __construct(TxnFeeReport $model)
    {
        parent::__construct($model);
    }

    /**
     * Summation of total data
     * @return int|float
     */
    public function totalData(string $txnType): float
    {
        return $this->model->where('txn_type', $txnType)->sum('usd_value');
    }

    /**
     * Summation of total current month data
     * @param string $txnType
     * @return float
     */
    public function sumCurrentMonthData(string $txnType): float
    {
        return $this->model->where('txn_type', $txnType)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('usd_value');
    }

    /**
     * sum previous month TxnReport
     * @return int
     */
    public function sumPreviousMonthData(string $txnType): float
    {
        return $this->model->where('txn_type', $txnType)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('usd_value');
    }

    /**
     * Summation of
     * @param string $txnType
     * @return array
     */
    public function sumYearlyChartData(string $txnType): array
    {
        $recent12MonthsCustomers = [];
        $currentMonth            = Carbon::now()->month;
        $currentYear             = Carbon::now()->year;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $totalAmount = $this->model->where('txn_type', $txnType)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('usd_value');

            $recent12MonthsCustomers[] = number_format($totalAmount, 2, '.', '');
        }

        return $recent12MonthsCustomers;
    }

    /**
     * Last ten transaction fee history
     *
     * @return int
     */
    public function recentTxnFeeData(): object
    {
        return $this->model->newQuery()->limit(10)->orderBy('id', 'desc')->with(['customerInfo', 'currencyInfo'])->get();
    }

}
