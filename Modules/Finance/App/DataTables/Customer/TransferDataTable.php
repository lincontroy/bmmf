<?php

namespace Modules\Finance\App\DataTables\Customer;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Finance\App\Enums\TransferStatusEnum;
use Modules\Finance\App\Models\Transfer;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransferDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->editColumn('status', function ($query) {
                return '<span class="badge bg-label-success py-2 w-px-75">' . TransferStatusEnum::DONE->name . '</span>';
            })
            ->addColumn('amount', function ($query) {
                return $query->amount . ' ' . $query->currency_symbol;
            })
            ->addColumn('fees', function ($query) {
                return $query->fees . ' ' . $query->currency_symbol;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transfer $model): QueryBuilder
    {
        return $model->where('sender_user_id', auth()->user()->user_id)->orderBy('id', 'desc')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'trans-table';
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
            Column::make('sender_user_id')->title(localize('Sender')),
            Column::make('receiver_user_id')->title(localize('Receiver')),
            Column::computed('amount')->title(localize('Amount')),
            Column::computed('fees')->title(localize('Fees'))->addClass('text-center'),
            Column::make('comments')->title(localize('Comments')),
            Column::make('created_at')->title(localize('Created At')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Transfer_' . date('YmdHis');
    }
}
