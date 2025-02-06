<?php

namespace Modules\B2xloan\App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Enums\B2xLoanWithdrawStatusEnum;
use Modules\B2xloan\App\Models\B2xLoan;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class B2xLoanWithdrawDataTable extends DataTable
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
                if ($query->withdraw_status->value === B2xLoanWithdrawStatusEnum::PENDING->value) {

                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeWithdrawStatus" action-type="confirm" title="'.localize("Confirm").'" data-action="' . route('b2x-loans-pending-withdraw.update', ['b2x_loans_pending_withdraw' => $query->id, 'set_status' => B2xLoanWithdrawStatusEnum::SUCCESS->value]) . '"><i class="fa fa-check"></i></a>';

                    $button .= '<a href="javascript:void(0)" class="btn btn-purple  text-white d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeWithdrawStatus" action-type="reject" title="'.localize("Reject").'" data-action="' . route('b2x-loans-pending-withdraw.update', ['b2x_loans_pending_withdraw' => $query->id, 'set_status' => B2xLoanWithdrawStatusEnum::CANCELED->value]) . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 m-1 userInfo" title="'.localize("Information").'" data-id="' . $query->customer_id . '" data-loan-id="' . $query->id . '" data-action="' . route('b2x-loan.getUser') . '"><i class="fa fa-info-circle"></i></a>';
                $button .= '</div>';

                return $button;
            })
            ->editColumn('created_at', function ($query) {
                return get_ymd($query->created_at);
            })
            ->editColumn('customer_id', function ($query) {
                return $query->customerInfo->first_name . " " . $query->customerInfo->last_name;
            })
            ->editColumn('b2x_loan_package_id', function ($query) {
                return $query->packageInfo->no_of_month . " Months";
            })
            ->editColumn('hold_btc_amount', function ($query) {
                return $query->hold_btc_amount . " BTC";
            })
            ->editColumn('loan_amount', function ($query) {
                return '$' . number_format($query->loan_amount, 2);
            })
            ->editColumn('interest_percent', function ($query) {
                return number_format($query->interest_percent, 2);
            })
            ->editColumn('installment_amount', function ($query) {
                return '$' . number_format($query->installment_amount, 2);
            })
            ->editColumn('paid_installment', function ($query) {
                return number_format($query->paid_installment, 0);
            })
            ->editColumn('remaining_installment', function ($query) {
                return number_format($query->remaining_installment, 0);
            })
            ->editColumn('status', function ($query) {

                if ($query->status->value === B2xLoanStatusEnum::APPROVED->value) {
                    $button = '<span class="badge bg-label-success py-2">' . B2xLoanStatusEnum::APPROVED->name . '</span>';
                } else if ($query->status->value === B2xLoanStatusEnum::PENDING->value) {
                    $button = '<span class="badge bg-label-warning py-2"><i class="fa fa-spinner fa-spin"></i> ' .
                        B2xLoanStatusEnum::PENDING->name . '</span>';
                } else if ($query->status->value === B2xLoanStatusEnum::REJECTED->value) {
                    $button = '<span class="badge bg-label-primary py-2">' . B2xLoanStatusEnum::REJECTED->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-danger py-2">' . B2xLoanStatusEnum::CLOSED->name . '</span>';
                }
                return $button;
            })
            ->editColumn('withdraw_status', function ($query) {
              return '<span class="badge bg-label-warning py-2"><i class="fa fa-spinner fa-spin"></i> Pending</span>';
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'withdraw_status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(B2xLoan $model): QueryBuilder
    {
        return $model->newQuery()->where('withdraw_status', B2xLoanWithdrawStatusEnum::PENDING->value)->with(['packageInfo',
            'customerInfo'])->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'b2x-loan-pending-withdraw-table';
        return $this->builder()
            ->setTableId($tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->dom("<'row m-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
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
            Column::make('created_at')->title(localize('Date')),
            Column::make('customer_id')->title(localize('Name')),
            Column::make('b2x_loan_package_id')->title(localize('Package')),
            Column::make('interest_percent')->title(localize('Interest').'(%)'),
            Column::make('loan_amount')->title(localize('Loan Amount')),
            Column::make('hold_btc_amount')->title(localize('Hold Amount')),
            Column::make('installment_amount')->title(localize('Installment')),
            Column::make('paid_installment')->title(localize('Paid Instl.')),
            Column::make('remaining_installment')->title(localize('Remain. Instl.')),
            Column::make('status')->title(localize('Loan Status')),
            Column::make('withdraw_status')->title(localize('Withdraw Status')),
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
        return 'B2xloans_' . date('YmdHis');
    }

}
