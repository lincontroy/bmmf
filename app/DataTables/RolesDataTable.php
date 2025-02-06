<?php

namespace App\DataTables;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Enums\AuthGuardEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class RolesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';
                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::UPDATE->value)) {
                $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 role-edit-button" title="'.localize("Edit").'" data-action="' . route('admin.role.update', ['role' => $query->id]) . '" data-route="' . route('admin.role.edit', ['role' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::DELETE->value)) {
                $button .= '<a href="javascript:void(0);" class="btn btn-danger-soft btn-sm m-1 delete-button" title="'.localize("Delete").'" data-action="' . route('admin.role.destroy', ['role' => $query->id]) . '"><i class="fa fa-trash"></i></a>';
                }
                $button .= '</div>';

                return $button;
            })
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('updated_at', function ($query) {
                return Carbon::parse($query->updated_at)->format('d/m/Y H:i:s');
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action']);

    }

    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('roles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->dom("<'row m-3'<'col-md-3'l><'col-md-5 d-flex align-items-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->parameters([
                'responsive'     => true,
                'autoWidth'      => false,
                'headerCallback' => 'function(thead, data, start, end, display) {
                    $(thead).addClass("bg-primary");
                    $(thead).find("th").addClass("text-white");
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('name')->title(localize('Name')),
            Column::make('created_at')->title(localize('Created At')),
            Column::make('updated_at')->title(localize('Updated At')),
            Column::computed('action')
                ->title(localize('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }

}
