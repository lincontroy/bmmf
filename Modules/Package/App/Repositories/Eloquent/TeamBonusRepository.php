<?php

namespace Modules\Package\App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Models\Package;
use Modules\Package\App\Models\TeamBonus;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\TeamBonusRepositoryInterface;

class TeamBonusRepository extends BaseRepository implements TeamBonusRepositoryInterface
{
    public function __construct(TeamBonus $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        return parent::create($attributes);
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function updateByUserId(string $userId, array $attributes): bool
    {
        return $this->model->where('user_id', $userId)->update($attributes);
    }

    /**
     * Summation of total data
     * @return int|float
     */
    public function totalData($userId = '', $type = ''): float
    {
        $column = 'team_commission';
        if($type == 'sponsor'){
            $column = 'sponsor_commission';
        }
        return $this->model->where(function ($query) use ($userId) {
            if (!empty($userId)) {
                $query->where('user_id', $userId);
            }
        })->sum($column);
    }

    /**
     * Summation of total current month data
     * @return float
     */
    public function sumCurrentMonthData($userId = '', $type = ''): float
    {
        $column = 'team_commission';
        if($type == 'sponsor'){
            $column = 'sponsor_commission';
        }
        return $this->model->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where(function ($query) use ($userId) {
                if (!empty($userId)) {
                    $query->where('user_id', $userId);
                }
            })->sum($column);
    }

    /**
     * sum previous month TxnReport
     * @return int
     */
    public function sumPreviousMonthData($userId, $type): float
    {
        $column = 'team_commission';
        if($type == 'sponsor'){
            $column = 'sponsor_commission';
        }

        return $this->model->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->where(function ($query) use ($userId) {
                if (!empty($userId)) {
                    $query->where('user_id', $userId);
                }
            })
            ->sum($column);
    }

    /**
     * Summation of
     * @return array
     */
    public function sumYearlyChartData($userId, $type): array
    {

        $recent12MonthsCustomers = [];
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $column = 'sponsor_commission';
        if($type == 'team-turnover'){
            $column = 'team_commission';
        }

        for ($month = 1; $month <= $currentMonth; $month++) {
            $totalAmount = $this->model->where('user_id', $userId)->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum($column);

            $recent12MonthsCustomers[] = number_format($totalAmount, 2, '.', '');
        }

        return $recent12MonthsCustomers;
    }
}
