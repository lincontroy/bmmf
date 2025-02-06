<?php

namespace Modules\Reports\App\DataTables;

use App\Enums\UserLogTypeEnum;
use App\Models\UserLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LoginHistoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))

            ->editColumn('access_time', function ($query) {
                return get_ymd($query->access_time);
            })
            ->editColumn('type', function ($query) {

                if ($query->type->value === UserLogTypeEnum::LOGIN->value) {

                    $button = '<span class="badge bg-label-success py-2"> <i class="fa fa-sign-in-alt" aria-hidden="true"></i> ' . UserLogTypeEnum::LOGIN->name . '</span>';

                } else {
                    $button = '<span class="badge bg-label-danger py-2"> <i class="fa fa-sign-out-alt" aria-hidden="true"></i> ' . UserLogTypeEnum::LOGOUT->name .
                        '</span>';
                }

                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserLog $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc')->with(['customerInfo']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "login-history";
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
            Column::make('type')->title(localize('Type'))->addClass('text-center'),
            Column::computed('access_time')->title(localize('Access Time')),
            Column::computed('user_agent')->title(localize('User Agent'))->addClass('text-center'),
            Column::computed('user_ip')->title(localize('User IP')),
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
