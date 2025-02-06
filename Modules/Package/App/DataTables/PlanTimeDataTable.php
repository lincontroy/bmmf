<?php

namespace Modules\Package\App\DataTables;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Package\App\Models\PlanTime;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Enums\AuthGuardEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class PlanTimeDataTable extends DataTable
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

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-button" data-action="' . route('admin.plan-time.update', ['plan_time' => $query->id]) . '" data-route="' . route('admin.plan-time.edit', ['plan_time' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::DELETE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 delete-button" data-action="' . route('admin.plan-time.destroy', ['plan_time' => $query->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';
                return $button;
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
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PlanTime $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'plan-time-table';
        return $this->builder()
            ->setTableId('plan-time-table')
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
            Column::make('name_')->title(localize('Name')),
            Column::make('hours_')->title(localize('Hours')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
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
        return 'Plan_time_' . date('YmdHis');
    }

}
