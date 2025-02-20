<?php

namespace Modules\Stake\App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Stake\App\Enums\CustomerStakeEnum;
use Modules\Stake\App\Models\CustomerStake;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Log;


class StakeSubscriptionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        
        return (new EloquentDataTable($query))
            ->addColumn('user', function ($customerStake) {

                Log::info($customerStake);
        Log::info($customerStake->customerInfo->first_name . ' ' . $customerStake->customerInfo->last_name);
                $imageLink =  assets('img/blank50x50.png');
                return '<div class="d-flex align-items-center gap-3">
                <div class="user-img rounded-circle">
                    <img src="' . $imageLink . '" alt="">
                </div>
                <div>
                    <p class="mb-1 fs-15 fw-medium">' . $customerStake->customerInfo->first_name . ' ' . $customerStake->customerInfo->last_name . '</p>
                    <p class="mb-0 fs-12 fw-normal">' . $customerStake->customerInfo->email . '</p>
                </div>
            </div>';
            })
            ->addColumn('coin', function ($customerStake) {
                $imageLink = $customerStake->acceptCurrency->logo ? assets('img/' . $customerStake->acceptCurrency->logo) : assets('img/blank50x50.png');
                return '<div class="fee-coin rounded-circle"><img src="' . $imageLink . '" alt=""></div>';
            })
            ->addColumn('locked_amount', function ($customerStake) {
                return $customerStake->locked_amount . ' ' . $customerStake->acceptCurrency->symbol;
            })
            ->addColumn('interest_amount', function ($customerStake) {
                return $customerStake->interestInfo->interest_amount . ' ' . $customerStake->acceptCurrency->symbol;
            })
            ->addColumn('duration', function ($customerStake) {
                return $customerStake->duration . ' Days';
            })
            ->editColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status', 'user', 'coin']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CustomerStake $model): QueryBuilder
    {
        $tab = $this->request->get('workStatus');

        $subscriptions = $model->newQuery()->with('customerInfo')->with('acceptCurrency')->with('interestInfo');

        if ($tab == 'holding') {
            $subscriptions = $subscriptions->where('status', CustomerStakeEnum::REDEEMED_ENABLE->value);
        } elseif ($tab == 'redeemed') {
            $subscriptions = $subscriptions->where('status', CustomerStakeEnum::REDEEMED->value);
        } elseif ($tab == 'pending') {
            $subscriptions = $subscriptions->where('status', CustomerStakeEnum::RUNNING->value);
        }

        return $subscriptions;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "stake-subscription-table";
        return $this->builder()
            ->setTableId($tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->dom("<'row m-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->parameters([
                'responsive'     => true,
                'autoWidth'      => false,
                'headerCallback' => 'function(thead, data, start, end, display) {
                            $(thead).addClass("bg-primary");
                            $(thead).find("th").addClass("text-white");
                            $("#' . $tableId . '").removeClass("table-striped table-hover");
                        }',
            ])
            ->buttons([
                Button::make('excel')->text('<i class="fa fa-file-excel"></i> Excel')->className('btn btn-success box-shadow--4dp btn-sm-menu'),
                Button::make('csv')->text('<i class="fa fa-file-csv"></i> CSV')->className('btn btn-success box-shadow--4dp btn-sm-menu'),
                Button::make('pdf')->text('<i class="fa fa-file-pdf"></i> PDF')->className('btn btn-success box-shadow--4dp btn-sm-menu'),
                Button::make('print')->text('<i class="fa fa-print"></i> Print')->className('btn btn-success box-shadow--4dp btn-sm-menu')->attr(['target' => '_blank']),
                Button::make('reset')->text('<i class="fa fa-undo-alt"></i> Reset')->className('btn btn-success box-shadow--4dp btn-sm-menu'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('user')->title(localize('User'))->searchable(false)->orderable(false)->addClass('text-center'),
            Column::computed('coin')->title(localize('Accepted coin'))->searchable(false)->orderable(false)->addClass('text-center'),
            Column::computed('locked_amount')->title(localize('Locked Amount')),
            Column::computed('interest_amount')->title(localize('Approx. Interest')),
            Column::computed('duration')->title(localize('Duration (days)')),
            Column::make('status')->title(localize('Status'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('created_at')->title(localize('Staked At')),
            Column::make('redemption_at')->title(localize('Redemption At')),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Subscription_' . date('YmdHis');
    }

    private function statusBtn($query): string
    {
        $textLabel = "danger";
        $status    = "Holding";

        if ($query->status->value == CustomerStakeEnum::REDEEMED->value) {
            $textLabel = "success";
            $status    = "Redeemed";
        } else

        if ($query->status->value == CustomerStakeEnum::RUNNING->value) {
            $textLabel = "primary";
            $status    = "Running";
        }

        return '<span class="badge bg-label-' . $textLabel . ' py-2 w-px-100">' . $status . '</span>';
    }

}
