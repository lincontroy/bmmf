<?php

namespace Modules\Finance\App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Finance\App\Enums\WithdrawStatusEnum;
use Modules\Finance\App\Models\Withdrawal;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PendingWithdrawDataTable extends DataTable
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

                $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 withdraw-confirm" action-type="confirm" title="' . localize("Confirm") . '" data-action="' . route('withdraw.update', ['withdraw' => $query->id, 'set_status' => WithdrawStatusEnum::SUCCESS->value]) . '"><i class="fa fa-check"></i></a>';

                $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 withdraw-confirm" action-type="cancel" title="' . localize("Cancel") . '" data-action="' . route('withdraw.update', ['withdraw' => $query->id, 'set_status' => WithdrawStatusEnum::CANCEL->value]) . '"><i class="fa fa-ban" aria-hidden="true"></i></a>';

                $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 m-1 userInfo" title="' . localize("Information") . '" data-id="' . $query->id . '" customer-id="' . $query->customer_id . '" data-action="' . route('withdraw_user_info') . '"><i class="fa fa-info-circle"></i></a>';
                $button .= '</div>';

                $button .= '</div>';
                return $button;
            })
            ->addColumn('payment_gateway_id', function ($query) {
                return $query->gatewayInfo['name'];
            })
            ->addColumn('amount', function ($query) {
                return $query->amount . ' ' . $query->currencyInfo['symbol'];
            })
            ->addColumn('fees', function ($query) {
                return $query->fees . ' ' . $query->currencyInfo['symbol'];
            })
            ->addColumn('credential', function ($query) {
                $credentialsData = '<ul>';

                foreach ($query->withdrawalAccount['credentials'] as $key => $value) {
                    $credentialsData .= '<li>' . $value->name . ' : ' . $value->credential . '</li>';
                }

                $credentialsData .= '</ul>';

                return $credentialsData;
            })
            ->editColumn('user_id', function ($query) {
                return $query->customerInfo['user_id'];
            })
            ->editColumn('status', function ($query) {

                if ($query->status->value === WithdrawStatusEnum::SUCCESS->value) {
                    $button = '<span class="badge bg-label-success py-2 w-px-75">' . WithdrawStatusEnum::SUCCESS->name . '</span>';
                } else

                if ($query->status->value === WithdrawStatusEnum::CANCEL->value) {
                    $button = '<span class="badge bg-label-danger py-2 w-px-75">' . WithdrawStatusEnum::CANCEL->name . '</span>';
                } else {
                    $button = '<span class="badge bg-label-warning py-2 w-px-75">' . WithdrawStatusEnum::PENDING->name . '</span>';
                }

                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'credential']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Withdrawal $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('status', WithdrawStatusEnum::PENDING->value)
            ->orderBy('id', 'desc')
            ->with('customerInfo', 'gatewayInfo');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'deposit-table';
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
            Column::make('user_id')->title(localize('User Id')),
            Column::computed('payment_gateway_id')->title(localize('Payment Gateway')),
            Column::computed('credential')->title(localize('Credential')),
            Column::computed('amount')->title(localize('Amount')),
            Column::computed('fees')->title(localize('Fees'))->addClass('text-center'),
            Column::make('comments')->title(localize('Comments')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
            Column::make('created_at')->title(localize('Created At')),
            Column::make('updated_at')->title(localize('Updated At')),
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
        return 'Pending_withdraw_' . date('YmdHis');
    }

}
