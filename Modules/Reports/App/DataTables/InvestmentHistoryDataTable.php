<?php

namespace Modules\Reports\App\DataTables;

use App\Enums\StatusEnum;
use App\Models\Investment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvestmentHistoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($query) {
                return get_ymd($query->created_at);
            })
            ->editColumn('expiry_at', function ($query) {
                return get_ymd($query->expiry_at);
            })
            ->editColumn('package_id', function ($query) {
                return $query->package->name;
            })
            ->editColumn('status', function ($query) {

                if ($query->status->value === StatusEnum::ACTIVE->value) {
                    $button = '<span class="badge bg-label-success py-2 w-px-75">' . StatusEnum::ACTIVE->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-warning py-2 w-px-75">' . StatusEnum::INACTIVE->name . '</span>';
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
    public function query(Investment $model): QueryBuilder
    {
        return $model->newQuery()->with(['package', 'customerInfo']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "investment-history";
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
            Column::make('user_id')->title(localize('User ID'))->addClass('text-center'),
            Column::make('package_id')->title(localize('Package')),
            Column::computed('invest_amount')->title(localize('Invest Amount')),
            Column::computed('invest_qty')->title(localize('Invest Qty'))->addClass('text-center'),
            Column::computed('total_invest_amount')->title(localize('Total Invest Amount')),
            Column::make('expiry_at')->title(localize('Expiry Date')),
            Column::make('created_at')->title(localize('Create Date')),
            Column::make('status')->title(localize('Status')),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Investment-History' . date('YmdHis');
    }

}
