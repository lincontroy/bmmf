<?php

namespace Modules\QuickExchange\App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Modules\QuickExchange\App\Repositories\Interfaces\QuickExchangeRequestRepositoryInterface;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QuickExchangeOrderRequestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('document', function ($quickExchangeOrder) {
                $imageLink = $quickExchangeOrder->document ? storage_asset($quickExchangeOrder->document) : assets('img/blank50x50.png');
                return $quickExchangeOrder->document ? '<img width="50" height="50" src="' . $imageLink . '" alt=""><br><a href="' . storage_asset($quickExchangeOrder->document) . '" download>Download</a>' : '';
            })
            ->addColumn('user_send_hash', function ($quickExchangeOrder) {
                return Str::substr($quickExchangeOrder->user_send_hash, 0, 5) . '...' . Str::substr($quickExchangeOrder->user_send_hash, -5);
            })
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';
                $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-button" data-action="' . route('quickexchange.show', ['quickexchange' => $query->request_id]) . '"><i class="fa fa-edit"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->editColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status', 'document', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(QuickExchangeRequestRepositoryInterface $model): QueryBuilder
    {
        return $model->quickExchangeOrderRequestDataTable(['status' => 0]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "quick_exchange_order_request";
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
            Column::make('sell_coin')->title(localize('Sell Coin'))->addClass('text-center'),
            Column::make('sell_amount')->title(localize('Sell Amount')),
            Column::make('buy_coin')->title(localize('Buy Coin'))->addClass('text-center'),
            Column::make('buy_amount')->title(localize('Buy Amount')),
            Column::computed('user_send_hash')->title(localize('User Send Hash')),
            Column::computed('document')->title(localize('Doc'))->addClass('text-center'),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
            Column::make('created_at')->title(localize('Created At')),
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
        return 'QuickExchangeOrderRequest_' . date('YmdHis');
    }

    private function statusBtn($query): string
    {
        $textLabel = "primary";
        $status    = '<span class="spinner-dotted me-2" role="status"> </span>
         <span>Processing</span>';

        return '<span class="badge bg-label-' . $textLabel . ' py-2">' . $status . '</span>';
    }

}
