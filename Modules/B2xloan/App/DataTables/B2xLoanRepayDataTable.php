<?php

namespace Modules\B2xloan\App\DataTables;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\B2xloan\App\Models\B2xLoanRepay;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class B2xLoanRepayDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('currency', function ($rows) {
                return '<div class="fee-coin rounded-circle"><img src="' . assets('img/' . $rows->acceptCurrency->logo) . '" alt=""></div>';
            })
            ->addColumn('user_id', function ($rows) {
                return $rows->b2xLoan->customerInfo->user_id;
            })
            ->addColumn('loan_amount', function ($rows) {
                return $rows->b2xLoan->loan_amount;
            })
            ->addColumn('installment_amount', function ($rows) {
                return $rows->b2xLoan->installment_amount;
            })
            ->editColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status', 'currency']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(B2xLoanRepay $model): QueryBuilder
    {
        $currentMonth = $this->currentMonth;
        $currentYear  = $this->currentYear;

        if (isset($currentMonth) && isset($currentYear)) {
            return $model->newQuery()->with(['acceptCurrency', 'b2xLoan.customerInfo'])
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->orderBy('id', 'desc');
        } else {
            return $model->newQuery()->with(['acceptCurrency', 'b2xLoan.customerInfo'])
                ->orderBy('id', 'desc');
        }

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'b2x-repay-table';
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
            Column::computed('currency')->title(localize('Currency'))->addClass('text-center'),
            Column::computed('user_id')->title(localize('User Id')),
            Column::computed('loan_amount')->title(localize('Loan Amount')),
            Column::computed('installment_amount')->title(localize('Installment')),
            Column::make('amount')->title(localize('Repay Amount')),
            Column::make('created_at')->title(localize('Payment Time')),
            Column::make('updated_at')->title(localize('Paid Time')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'B2xLoans_' . date('YmdHis');
    }

    private function statusBtn($query): string
    {
        $textLabel = "primary";
        $status    = "Pending";

        if ($query->status == StatusEnum::ACTIVE->value) {
            $textLabel = "success";
            $status    = "Success";
        }

        return '<span class="badge bg-label-' . $textLabel . ' py-2">' . $status . '</span>';
    }

}
