<?php

namespace App\DataTables\Customer\earning;

use App\Enums\EarningTypeEnum;
use App\Models\Earning;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Modules\Package\App\Models\UserLevel;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TeamBonusDataTable extends DataTable
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
                    return '<span class="badge bg-label-success py-2">' . localize('completed') . '</span>';
            })
            ->editColumn('bonus', function ($query) {
                return number_format($query->bonus,2);
            })
            ->editColumn('achieve_date', function ($query) {
                return get_ymd($query->achieve_date);
            })
            ->rawColumns(['status'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserLevel $model): QueryBuilder
    {
        $userId = Auth::user()->user_id;

        return $model->newQuery()->where('user_id', $userId)->with('setupCommission');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'team-commission-table';

        return $this->builder()
                    ->addTableClass('w-100')
                    ->setTableId($tableId)
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom(
                        "<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>"
                    )
                    ->orderBy(1)
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
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(30)->addClass(
                'text-center'
            ),
            Column::make('achieve_date')->title(localize('date')),
            Column::make('level_id')->title(localize('level')),
            Column::make('bonus')->title(localize('bonus')),
            Column::make('status')->title(localize('status')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Referral_commission_' . date('YmdHis');
    }
}
