<?php

namespace Modules\Package\App\DataTables;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Enums\CoinSymbolEnum;
use Modules\Package\App\Enums\InterestTypeEnum;
use Modules\Package\App\Enums\InvestTypeEnum;
use Modules\Package\App\Enums\ReturnTypeEnum;
use Modules\Package\App\Models\Package;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Enums\AuthGuardEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class PackagesDataTable extends DataTable
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

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-button" data-action="' . route('admin.package.update', ['package' => $query->id]) . '" data-route="' . route('admin.package.edit', ['package' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::DELETE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 delete-button" data-action="' . route('admin.package.destroy', ['package' => $query->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';
                return $button;
            })
            ->editColumn('min_price', function ($query) {

                if ($query->invest_type->value === InvestTypeEnum::RANGE->value) {
                    return $query->min_price . ' - ' . $query->max_price . ' ' . CoinSymbolEnum::USD->value;
                } else {
                    return $query->min_price . ' ' . CoinSymbolEnum::USD->value;
                }

            })
            ->editColumn('max_price', function ($query) {

                if ($query->max_price) {
                    return $query->max_price . ' ' . CoinSymbolEnum::USD->value;
                }

            })
            ->editColumn('interest', function ($query) {

                if ($query->interest_type->value === InterestTypeEnum::PERCENT->value) {
                    return $query->interest . ' %';
                } else {
                    return $query->interest . ' ' . CoinSymbolEnum::USD->value;
                }

            })
            ->editColumn('return_type', function ($query) {

                if ($query->return_type->value === ReturnTypeEnum::LIFE_TIME->value) {
                    return str_replace('_', ' ', ReturnTypeEnum::LIFE_TIME->name);
                } else {
                    return ReturnTypeEnum::REPEAT->name;
                }

            })
            ->editColumn('capital_back', function ($query) {

                if ($query->capital_back->value === CapitalBackEnum::NO->value) {
                    return CapitalBackEnum::NO->name;
                } else {
                    return CapitalBackEnum::YES->name;
                }

            })
            ->editColumn('plan_time_id', function ($query) {

                return $query->planTime['name_'];

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
    public function query(Package $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('planTime')
            ->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'packages-table';
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
            Column::make('name')->title(localize('Name')),
            Column::make('plan_time_id')->title(localize('Plan Time')),
            Column::make('min_price')->title(localize('Price')),
            Column::make('interest')->title(localize('Interest')),
            Column::make('return_type')->title(localize('Return Type')),
            Column::make('repeat_time')->title(localize('Repeat Time')),
            Column::make('capital_back')->title(localize('Capital Back')),
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
        return 'Packages_' . date('YmdHis');
    }

}
