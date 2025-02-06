<?php

namespace Modules\Merchant\App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Modules\Merchant\App\Enums\MerchantWithdrawEnum;
use Modules\Merchant\App\Models\MerchantWithdraw;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ConfirmWithdrawDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '<a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center justify-content-center py-2 rounded-3 m-1 userInfo" title="' . localize(
                        "Information"
                    ) . '" data-id="' . $query->user_id . '" data-action="' . route(
                        'admin.finance.getUser'
                    ) . '"><i class="fa fa-info-circle"></i></a>';

                $button .= '</div>';

                return $button;
            })
            ->editColumn('request_date', function ($query) {
                return get_ymd($query->request_date);
            })
            ->editColumn('merchant_account_id', function ($query) {
                return $query->merchantInfo['store_name'];
            })
            ->editColumn('accept_currency_id', function ($query) {
                return $query->coinInfo['symbol'];
            })
            ->editColumn('wallet_id', function ($query) {
                return Str::substr($query->wallet_id, 0, 5) . '*****' . Str::substr($query->wallet_id, -5);
            })
            ->editColumn('status', function ($query) {
                return '<span class="badge bg-label-success py-2"> ' .
                    MerchantWithdrawEnum::CONFIRM->name . '</span>';
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MerchantWithdraw $model): QueryBuilder
    {
        return $model->newQuery()->where('status', MerchantWithdrawEnum::CONFIRM->value)
                     ->orderBy('id', 'desc')
                     ->with(['merchantInfo', 'coinInfo']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'merchant-withdraw-table';

        return $this->builder()
                    ->setTableId($tableId)
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0)
                    ->dom(
                        "<'row m-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>"
                    )
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'headerCallback' => 'function(thead, data, start, end, display) {
                            $(thead).addClass("bg-primary");
                            $(thead).find("th").addClass("text-white");
                            $("#' . $tableId . '").removeClass("table-striped table-hover");
                        }',
                    ])
                    ->buttons([
                        Button::make('excel')->text('<i class="fa fa-file-excel"></i> Excel')->className(
                            'btn btn-success box-shadow--4dp btn-sm-menu'
                        ),
                        Button::make('csv')->text('<i class="fa fa-file-csv"></i> CSV')->className(
                            'btn btn-success box-shadow--4dp btn-sm-menu'
                        ),
                        Button::make('pdf')->text('<i class="fa fa-file-pdf"></i> PDF')->className(
                            'btn btn-success box-shadow--4dp btn-sm-menu'
                        ),
                        Button::make('print')->text('<i class="fa fa-print"></i> Print')->className(
                            'btn btn-success box-shadow--4dp btn-sm-menu'
                        )->attr(['target' => '_blank']),
                        Button::make('reset')->text('<i class="fa fa-undo-alt"></i> Reset')->className(
                            'btn btn-success box-shadow--4dp btn-sm-menu'
                        ),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(
                30
            )->addClass('text-center'),
            Column::make('request_date')->title(localize('Date')),
            Column::make('merchant_account_id')->title(localize('Store Name')),
            Column::make('user_id')->title(localize('User')),
            Column::make('wallet_id')->addClass('text-center')->title(localize('Wallet ID')),
            Column::make('method')->title(localize('Method')),
            Column::make('amount')->title(localize('Amount'))->addClass('text-right'),
            Column::make('accept_currency_id')->addClass('text-center')->title(localize('Accept Currency')),
            Column::make('comments')->title(localize('Comments')),
            Column::make('status')->title(localize('Status'))->addClass('setStatus'),
            Column::computed('action')->title(localize('Action'))
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Merchant_withdraw_' . date('YmdHis');
    }

}
