<?php

namespace Modules\B2xloan\App\DataTables\Customer;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Enums\B2xLoanWithdrawStatusEnum;
use Modules\B2xloan\App\Models\B2xLoan;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LoansDataTable extends DataTable
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
                if (
                    $query->status->value === B2xLoanStatusEnum::APPROVED->value &&
                    (
                        $query->withdraw_status->value === B2xLoanWithdrawStatusEnum::NOT_SUBMIT->value ||
                        $query->withdraw_status->value === B2xLoanWithdrawStatusEnum::CANCELED->value
                    )
                ) {
                    $button .= '<a href="javascript:void(0)" data-id="' . $query->id . '" class="btn btn-warning text-white d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 withdrawRequest" action-type="withdraw" title="'.localize("Withdraw").'" data-action="' . route(
                            'b2x-loans.update',
                            ['b2x_loans' => $query->id, 'set_status' => B2xLoanWithdrawStatusEnum::PENDING->value]
                        ) . '">' . localize('withdraw') . '</a>';
                }
                if ($query->withdraw_status->value === B2xLoanWithdrawStatusEnum::SUCCESS->value && $query->status->value !== B2xLoanStatusEnum::CLOSED->value) {
                    $button .= '<a href="' . route('customer.repayment.show', [$query->id]
                        ) . '" data-id="' . $query->id . '" class="btn btn-success text-white d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 repayLoan" action-type="repay" title="'.localize("Repay").'" data-action="' . route(
                            'b2x-loans.update',
                            ['b2x_loans' => $query->id, 'set_status' => B2xLoanWithdrawStatusEnum::SUCCESS->value]
                        ) . '">' . localize('repay') . '</a>';
                }
                $button .= '</div>';

                return $button;
            })
            ->editColumn('b2x_loan_package_id', function ($query) {
                return $query->packageInfo->no_of_month . ' Months';
            })
            ->editColumn('interest_percent', function ($query) {
                return number_format($query->interest_percent, 2);
            })
            ->editColumn('loan_amount', function ($query) {
                return '$' . number_format($query->loan_amount, 2);
            })
            ->editColumn('installment_amount', function ($query) {
                return '$' . number_format($query->installment_amount, 2);
            })
            ->editColumn('number_of_installment', function ($query) {
                return number_format($query->number_of_installment, 0);
            })
            ->editColumn('paid_installment', function ($query) {
                return number_format($query->paid_installment, 0);
            })
            ->editColumn('remaining_installment', function ($query) {
                return number_format($query->remaining_installment, 0);
            })
            ->editColumn('status', function ($query) {
                $button = '';
                if ($query->status->value === B2xLoanStatusEnum::APPROVED->value) {
                    $button = '<span class="badge bg-label-success py-2">' . B2xLoanStatusEnum::APPROVED->name . '</span>';
                } elseif ($query->status->value === B2xLoanStatusEnum::PENDING->value) {
                    $button = '<span class="badge bg-label-warning py-2"><i class="fa fa-spinner fa-spin"></i> ' .
                        B2xLoanStatusEnum::PENDING->name . '</span>';
                } elseif ($query->status->value === B2xLoanStatusEnum::REJECTED->value) {
                    $button = '<span class="badge bg-label-primary py-2">' . B2xLoanStatusEnum::REJECTED->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-danger py-2">' . B2xLoanStatusEnum::CLOSED->name . '</span>';
                }

                return $button;
            })
            ->editColumn('withdraw_status', function ($query) {
                $button = '';
                if ($query->withdraw_status->value === B2xLoanWithdrawStatusEnum::PENDING->value) {
                    $button = '<span class="badge bg-label-warning py-2">' . B2xLoanWithdrawStatusEnum::PENDING->name . '</span>';
                } elseif ($query->withdraw_status->value === B2xLoanWithdrawStatusEnum::SUCCESS->value) {
                    $button = '<span class="badge bg-label-success py-2 w-px-75">' . B2xLoanWithdrawStatusEnum::SUCCESS->name . '</span>';
                } elseif ($query->withdraw_status->value === B2xLoanWithdrawStatusEnum::CANCELED->value) {
                    $button = '<span class="badge bg-label-danger py-2 w-px-75">' . localize('reject') . '</span>';
                }

                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'withdraw_status', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(B2xLoan $model): QueryBuilder
    {
        $customerId = Auth::id();

        return $model->newQuery()
                     ->where('customer_id', $customerId)
                     ->with('packageInfo')
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
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass(
                'text-center'
            ),
            Column::make('b2x_loan_package_id')->title(localize('Package')),
            Column::make('interest_percent')->title(localize('Interest') . " %"),
            Column::make('loan_amount')->title(localize('Amount')),
            Column::make('hold_btc_amount')->title(localize('Hold') . "(BTC)"),
            Column::make('installment_amount')->title(localize('Inst. Amount')),
            Column::make('number_of_installment')->addClass('text-center')->title(localize('Installment')),
            Column::make('paid_installment')->addClass('text-center')->title(localize('Paid') . " Inst."),
            Column::make('remaining_installment')->addClass('text-center')->title('Rem. Inst.'),
            Column::make('checker_note')->title(localize('Remarks')),
            Column::make('status')->addClass('text-center')->title(localize('Loan Status')),
            Column::make('withdraw_status')->addClass('text-center')->title(localize('Withdraw Status')),
            Column::make('withdraw_note')->addClass('text-center')->title(localize('Withdraw Note')),
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
        return 'My_loans_' . date('YmdHis');
    }

}
