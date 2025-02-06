<?php

namespace App\Repositories\Eloquent;

use App\Models\InvestmentRoi;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\InvestmentEarningRepositoryInterface;
use Carbon\Carbon;

class InvestmentEarningRepository extends BaseRepository implements InvestmentEarningRepositoryInterface
{
    public function __construct(InvestmentRoi $model)
    {
        parent::__construct($model);
    }

    /**
     * get recent data
     *
     * @param array $attributes
     * @return void
     */
    public function recentData(array $attributes): ?object
    {
        return $this->model->newQuery()
            ->where('user_id', $attributes['user_id'])
            ->limit($attributes['limit'])
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Summation of total data
     * @return int|float
     */
    public function totalData($userId = ''): float
    {
        return $this->model->where(function ($query) use ($userId) {
            if (!empty($userId)) {
                $query->where('user_id', $userId);
            }
        })->sum('roi_amount');
    }

    /**
     * Summation of total current month data
     * @return float
     */
    public function sumCurrentMonthData($userId = ''): float
    {
        return $this->model->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where(function ($query) use ($userId) {
                if (!empty($userId)) {
                    $query->where('user_id', $userId);
                }
            })->sum('roi_amount');
    }

    /**
     * sum previous month TxnReport
     * @return int
     */
    public function sumPreviousMonthData($userId = ''): float
    {
        return $this->model->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->where(function ($query) use ($userId) {
                if (!empty($userId)) {
                    $query->where('user_id', $userId);
                }
            })
            ->sum('roi_amount');
    }

    /**
     * Summation of
     * @return array
     */
    public function sumYearlyChartData($userId): array
    {
        $recent12MonthsCustomers = [];
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $totalAmount = $this->model->where('user_id', $userId)->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('roi_amount');

            $recent12MonthsCustomers[] = number_format($totalAmount, 2, '.', '');
        }

        return $recent12MonthsCustomers;
    }
}