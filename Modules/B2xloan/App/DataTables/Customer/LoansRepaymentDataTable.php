<?php

namespace Modules\B2xloan\App\DataTables\Customer;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Modules\B2xloan\App\Enums\B2xLoanRepaymentStatusEnum;
use Modules\B2xloan\App\Models\B2xLoanRepay;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LoansRepaymentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('b2x_loan_id', function ($query) {
                return $query->b2xLoan->packageInfo->no_of_month . ' Months';
            })
            ->editColumn('accept_currency_id', function ($query) {
                return $query->acceptCurrency->name;
            })
            ->editColumn('status', function ($query) {
                $button = '';

                if ($query->status === B2xLoanRepaymentStatusEnum::SUCCESS->value) {
                    $button = '<span class="badge bg-label-success py-2">' . B2xLoanRepaymentStatusEnum::SUCCESS->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-danger py-2">' . B2xLoanRepaymentStatusEnum::PENDING->name . '</span>';
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
    public function query(B2xLoanRepay $model): QueryBuilder
    {
        $customerId = Auth::id();

        return $model->newQuery()
            ->where('customer_id', $customerId)
            ->with(['acceptCurrency', 'b2xLoan.packageInfo'])
            ->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'my-loans-table';

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
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass(
                'text-center'
            ),
            Column::make('created_at')->title(localize('Date')),
            Column::make('b2x_loan_id')->title(localize('Package')),
            Column::make('accept_currency_id')->title(localize('Currency')),
            Column::make('amount')->title(localize('Amount')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'My_loans_repay' . date('YmdHis');
    }

}
