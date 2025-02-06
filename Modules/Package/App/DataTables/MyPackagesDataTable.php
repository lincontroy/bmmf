<?php

namespace Modules\Package\App\DataTables;

use App\Enums\InvestDetailStatusEnum;
use App\Models\Investment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Modules\Package\App\Enums\CoinSymbolEnum;
use Modules\Package\App\Enums\InterestTypeEnum;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MyPackagesDataTable extends DataTable
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
                $button .= '<a href="' . route('customer.packages_purchased', [$query->id]
                ) . '" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $button .= '</div>';

                return $button;
            })
            ->editColumn('package_id', function ($query) {
                return $query->package->name;
            })
            ->editColumn('interest', function ($query) {

                if ($query->package->interest_type->value === InterestTypeEnum::PERCENT->value) {
                    return $query->package->interest . ' %';
                } else {
                    return $query->package->interest . ' ' . CoinSymbolEnum::USD->value;
                }

            })
            ->editColumn('invest_amount', function ($query) {
                return number_format($query->invest_amount, 2);
            })
            ->editColumn('paid_roi_amount', function ($query) {
                return number_format($query->details->paid_roi_amount, 2);
            })
            ->editColumn('status', function ($query) {

                if ($query->details->status->value === InvestDetailStatusEnum::PAUSE->value) {
                    $button = '<span class="badge bg-label-warning py-2 w-px-75">' . InvestDetailStatusEnum::PAUSE->name . '</span>';
                } elseif ($query->details->status->value === InvestDetailStatusEnum::RUNNING->value) {
                    $button = '<span class="badge bg-label-primary py-2 w-px-75">' . InvestDetailStatusEnum::RUNNING->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-success py-2 w-px-75">' . InvestDetailStatusEnum::COMPLETE->name . '</span>';
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
    public function query(Investment $model): QueryBuilder
    {
        $userId = Auth::user()->user_id;

        return $model->newQuery()
            ->where('user_id', $userId)
            ->with(['details', 'package'])
            ->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'my-packages-table';

        return $this->builder()
            ->setTableId($tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->dom(
                "<'row m-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>"
            )
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
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('id')->title(localize('Order ID')),
            Column::make('package_id')->title(localize('Package')),
            Column::make('interest')->title(localize('Interest')),
            Column::make('invest_amount')->title(localize('Amount')),
            Column::make('paid_roi_amount')->title(localize('Paid')),
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
        return 'My_packages_' . date('YmdHis');
    }

}
