<?php

namespace App\Repositories\Eloquent;

use App\Models\Investment;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\InvestmentRepositoryInterface;
use Carbon\Carbon;

class InvestmentRepository extends BaseRepository implements InvestmentRepositoryInterface
{
    public function __construct(Investment $model)
    {
        parent::__construct($model);
    }

    /**
     * get investments by user id
     *
     * @param array $attributes
     * @return void
     */
    public function getAllInvestments(array $attributes): ?object
    {
        return $this->model->newQuery()->where('user_id', $attributes['user_id'])->orderBy(
            'id',
            'desc'
        )->with('package')->get();
    }

    /**
     * Summation of total data
     * @return int|float
     */
    public function totalData($userId = ''): float
    {
        return $this->model->where(function($query) use($userId){
            if(!empty($userId)){
                $query->where('user_id', $userId);
            }
        })->sum('total_invest_amount');
    }

    /**
     * Summation of total current month data
     * @return float
     */
    public function sumCurrentMonthData($userId = ''): float
    {
        return $this->model->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where(function($query) use($userId){
                if(!empty($userId)){
                    $query->where('user_id', $userId);
                }
            })->sum('total_invest_amount');
    }

    /**
     * sum previous month TxnReport
     * @return int
     */
    public function sumPreviousMonthData($userId = ''): float
    {
        return $this->model->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->where(function($query) use($userId){
                if(!empty($userId)){
                    $query->where('user_id', $userId);
                }
            })
            ->sum('total_invest_amount');
    }

    /**
     * Summation of
     * @return array
     */
    public function sumYearlyChartData($userId = ''): array
    {
        $recent12MonthsCustomers = [];
        $currentMonth            = Carbon::now()->month;
        $currentYear             = Carbon::now()->year;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $totalAmount = $this->model->whereYear('created_at', $currentYear)
                ->where(function($query) use($userId){
                    if(!empty($userId)){
                        $query->where('user_id', $userId);
                    }
                })
                ->whereMonth('created_at', $month)
                ->sum('total_invest_amount');

            $recent12MonthsCustomers[] = number_format($totalAmount, 2, '.', '');
        }

        return $recent12MonthsCustomers;
    }

    public function historyChartData(string $dataType): array
    {
        $data = [];

        if ($dataType === 'm') {
            $investments = Investment::selectRaw('SUM(total_invest_amount) as total_amount, YEAR(created_at) as year, MONTH(created_at) as month')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            foreach ($investments as $investment) {
                $label            = Carbon::createFromDate($investment->year, $investment->month, 1)->format('M Y');
                $data['labels'][] = $label;
                $data['values'][] = $investment->total_amount;
            }

        } elseif ($dataType === 'y') {
            $investments = Investment::selectRaw('SUM(total_invest_amount) as total_amount, YEAR(created_at) as year')
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            foreach ($investments as $investment) {
                $data['labels'][] = $investment->year;
                $data['values'][] = $investment->total_amount;
            }

        }

        return $data;
    }

    /**
     * Fetch invest history data
     * @return object
     */
    public function investmentHistoryData(): object
    {
        return $this->model->limit(10)->orderBy('created_at', 'desc')->get();
    }

    public function investmentCount($sponsorId)
    {
        return $this->model->where('user_id', $sponsorId)->count();
    }

    public function myPackages($attributes): object
    {
        $userId = $attributes['user_id'];

        return $this->model->where('user_id', $userId)->with(['details', 'package']);
    }

    public function investmentReport(array $attributes): object
    {
        $userId = $attributes['user_id'];

        return $this->model->where('user_id', $userId)->sum('total_invest_amount');
    }

}