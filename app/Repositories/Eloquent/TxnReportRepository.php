<?php

namespace App\Repositories\Eloquent;

use App\Enums\TxnTypeEnum;
use App\Models\TxnReport;
use App\Repositories\Interfaces\TxnReportRepositoryInterface;
use Carbon\Carbon;

class TxnReportRepository extends BaseRepository implements TxnReportRepositoryInterface
{
    public function __construct(TxnReport $model)
    {
        parent::__construct($model);
    }

    /**
     * Summation of total data
     *
     * @return int|float
     */
    public function totalData(string $txnType, $customerId = ''): float
    {
        return $this->model
            ->where('txn_type', $txnType)
            ->where(function ($query) use ($customerId) {

                if (!empty($customerId)) {
                    $query->where('customer_id', $customerId);
                }

            })
            ->sum('usd_value');
    }

    /**
     * Summation of total current month data
     * @param string $txnType
     * @return float
     */
    public function sumCurrentMonthData(string $txnType, $customerId): float
    {
        return $this->model->where('txn_type', $txnType)
            ->where(function ($query) use ($customerId) {

                if (!empty($customerId)) {
                    $query->where('customer_id', $customerId);
                }

            })
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('usd_value');
    }

    /**
     * sum previous month TxnReport
     * @return int
     */
    public function sumPreviousMonthData(string $txnType, $customerId): float
    {
        return $this->model->where('txn_type', $txnType)
            ->where(function ($query) use ($customerId) {

                if (!empty($customerId)) {
                    $query->where('customer_id', $customerId);
                }

            })
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('usd_value');
    }

    /**
     * Summation of
     * @param string $txnType
     * @return array
     */
    public function sumYearlyChartData(string $txnType, $customerId): array
    {
        $recent12MonthsCustomers = [];
        $currentMonth            = Carbon::now()->month;
        $currentYear             = Carbon::now()->year;

        for ($month = 1; $month <= $currentMonth; $month++) {
            $totalAmount = $this->model->where('txn_type', $txnType)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where(function ($query) use ($customerId) {

                    if (!empty($customerId)) {
                        $query->where('customer_id', $customerId);
                    }

                })
                ->sum('usd_value');

            $recent12MonthsCustomers[] = number_format($totalAmount, 2, '.', '');
        }

        return $recent12MonthsCustomers;
    }

    public function historyChartData(string $tnxType, string $dataType): array
    {
        $data = [];

        if ($dataType === 'm') {
            $investments = $this->model->selectRaw('SUM(usd_value) as total_amount, YEAR(created_at) as year, MONTH(created_at) as month')
                ->where('txn_type', $tnxType)
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

            $investments = $this->model->selectRaw('SUM(usd_value) as total_amount, YEAR(created_at) as year')
                ->where('txn_type', $tnxType)
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
     * Latest transaction history
     *
     * @return void
     */
    public function recentTnxData(): ?object
    {
        return $this->model->newQuery()->limit(10)->orderBy('id', 'desc')->with(['customerInfo', 'currencyInfo'])->get();
    }

    /**
     * Latest transaction history
     *
     * @return void
     */
    public function latestTxnData($attributes = []): array
    {
        $attributes['txn_type'] = TxnTypeEnum::DEPOSIT->value;
        $deposits               = $this->baseQuery($attributes, ['customerInfo', 'currencyInfo']);

        $attributes['txn_type'] = TxnTypeEnum::WITHDRAW->value;
        $withdraws              = $this->baseQuery($attributes, ['customerInfo', 'currencyInfo']);

        $attributes['txn_type'] = TxnTypeEnum::TRANSFER->value;
        $transfers              = $this->baseQuery($attributes, ['customerInfo', 'currencyInfo']);

        return compact('deposits', 'withdraws', 'transfers');
    }

    /**
     * @param array $attributes
     * @param array $relation
     * @return void
     */
    public function baseQuery(array $attributes, array $relation = []): ?object
    {
        $query = $this->model->newQuery()
            ->with($relation)
            ->where('txn_type', $attributes['txn_type'])
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();

        if (!empty($attributes['customer_id'])) {
            $query->where('customer_id', $attributes['customer_id']);
        }

        return $query;
    }

    /**
     * Summary of acceptCurrencyChartData
     * @return mixed
     */
    public function acceptCurrencyChartData(): ?object
    {
        return $this->model->selectRaw('accept_currency_id, SUM(amount) as total_amount')
            ->where('txn_type', TxnTypeEnum::DEPOSIT->value)
            ->groupBy('accept_currency_id')
            ->get();
    }

    /**
     * Latest transaction history
     *
     * @return void
     */
    public function customerRecentData($attributes = []): array
    {
        $deposits = $this->model->newQuery()->where('customer_id', $attributes['customer_id'])->where(
            'txn_type',
            TxnTypeEnum::DEPOSIT->value
        )->with(['customerInfo', 'currencyInfo'])->get();

        $withdraws = $this->model->newQuery()->where('customer_id', $attributes['customer_id'])->where(
            'txn_type',
            TxnTypeEnum::WITHDRAW->value
        )->with(['customerInfo', 'currencyInfo'])->get();
        $transfers = $this->model->newQuery()->where('customer_id', $attributes['customer_id'])->where(
            'txn_type',
            TxnTypeEnum::TRANSFER->value
        )->with(['customerInfo', 'currencyInfo'])->get();

        return compact('deposits', 'withdraws', 'transfers');
    }

}