<?php

namespace Modules\Finance\App\DataTables\Customer;

use App\Models\WithdrawalAccount;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WithdrawAccountDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('payment_gateway_id', function ($query) {
                return $query->gateway['name'];
            })
            ->addColumn('accept_currency_id', function ($query) {
                return $query->currency['symbol'];
            })
            ->addColumn('credential', function ($query) {

                $credentialsData = '<ul>';

                foreach ($query->credentials as $key => $value) {
                    $credentialsData .= '<li>' . $value->name . ' : ' . $value->credential . '</li>';
                }

                $credentialsData .= '</ul>';

                return $credentialsData;

            })
            ->editColumn('action', function ($query) {

                $button = '<div class="d-flex align-items-center">';
                $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 delete-button" data-action="' . route('customer.withdraw.account.destroy', ['account_id' => $query->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'credential']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawalAccount $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('customer_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->with('currency', 'gateway', 'credentials');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'withdrawal-account-table';
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
            Column::computed('payment_gateway_id')->title(localize('Payment Gateway')),
            Column::computed('accept_currency_id')->title(localize('Currency')),
            Column::computed('credential')->title(localize('Credential')),
            Column::make('created_at')->title(localize('Created At')),
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
        return 'Withdraw_account_' . date('YmdHis');
    }

}
