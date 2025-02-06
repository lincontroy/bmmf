<?php

namespace Modules\Merchant\App\DataTables\Customer;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Merchant\App\Enums\MerchantWithdrawEnum;
use Modules\Merchant\App\Models\MerchantWithdraw;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WithdrawDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('payment_gateway_id', function ($query) {
                return $query->gatewayInfo['name'];
            })
            ->addColumn('amount', function ($query) {
                return number_format($query->amount, 3, '.', '') . ' ' . $query->coinInfo['symbol'];
            })
            ->addColumn('fees', function ($query) {
                return number_format($query->fees, 3, '.', '') . ' ' . $query->coinInfo['symbol'];
            })
            ->editColumn('status', function ($query) {

                if ($query->status->value === MerchantWithdrawEnum::CONFIRM->value) {
                    $button = '<span class="badge bg-label-success py-2 w-px-75">' . MerchantWithdrawEnum::CONFIRM->name . '</span>';
                } else

                if ($query->status->value === MerchantWithdrawEnum::CANCEL->value) {
                    $button = '<span class="badge bg-label-danger py-2 w-px-75">' . MerchantWithdrawEnum::CANCEL->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-warning py-2 w-px-75">' . MerchantWithdrawEnum::PENDING->name . '</span>';
                }

                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MerchantWithdraw $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('user_id', auth()->user()->user_id)
            ->orderBy('id', 'desc');

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'withdraw-table';
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
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::computed('payment_gateway_id')->title(localize('Payment Gateway')),
            Column::computed('amount')->title(localize('Amount')),
            Column::computed('fees')->title(localize('Fees'))->addClass('text-center'),
            Column::make('comments')->title(localize('Comments')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
            Column::make('created_at')->title(localize('Created At')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Withdraw_' . date('YmdHis');
    }

}