<?php

namespace App\DataTables\Customer\earning;

use App\Models\InvestmentRoi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Modules\Package\App\Enums\InterestTypeEnum;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvestInterestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('investment_id', function ($query) {
                return '$' . $query->investment->total_invest_amount;
            })
            ->editColumn('interest', function ($query) {

                if ($query->investment->package->invest_type->value === InterestTypeEnum::PERCENT->value) {
                    $amount = $query->investment->package->interest . '%';
                } else {
                    $amount = '$' . $query->investment->package->interest;
                }

                return $amount;
            })
            ->editColumn('interest_amount', function ($query) {

                if ($query->investment->package->invest_type->value === InterestTypeEnum::PERCENT->value) {
                    $amount = '$' . number_format(
                        ((($query->investment->package->interest * $query->investment->total_invest_amount) / 100)),
                        2
                    );
                } else {
                    $amount = '$' . $query->investment->package->interest;
                }

                return '<span class="text-warning">' . $amount . '</span>';
            })
            ->editColumn('roi_amount', function ($query) {
                return '<span class="text-success">$' . $query->roi_amount . '</span>';
            })
            ->editColumn('purchase_quantity', function ($query) {
                return $query->investment->invest_qty;
            })
            ->rawColumns(['user_id', 'interest_amount', 'roi_amount'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InvestmentRoi $model): QueryBuilder
    {
        $userId = Auth::user()->user_id;

        return $model->newQuery()->where('user_id', $userId)->with(['investment', 'investment.package']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'investment-interest-table';

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
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->width(30)->addClass(
                'text-center'
            ),
            Column::make('investment_id')->title(localize('invest_amount')),
            Column::make('purchase_quantity')->addClass('text-center')->title(localize('qty')),
            Column::make('interest')->addClass('text-center')->title(localize('Interest')),
            Column::make('interest_amount')->title(localize('Interest Amount')),
            Column::make('roi_amount')->title(localize('received_amount')),
            Column::make('received_at')->title(localize('Received At')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Investment_Interest_' . date('YmdHis');
    }

}
