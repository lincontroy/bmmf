<?php

namespace App\DataTables;

use App\Enums\AuthGuardEnum;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\StatusEnum;
use App\Models\AcceptCurrency;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AcceptCurrencyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('logo', function ($query) {
                return '<div class="fee-coin rounded-circle"><img src="' . assets('img/' . $query->logo) . '" alt=""></div>';
            })
            ->addColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->addColumn('payment_gateway', function ($query) {
                $gatewayInfo = '<div class="d-flex align-items-center gap-2">';

                foreach ($query->currencyGateway as $key => $value) {
                    $gatewayInfo .= '<span class="bg-primary p-1 fs-15 text-white rounded-2">' . $value->gatewayInfo->name . '</span>';
                }

                $gatewayInfo .= '</div>';

                return $gatewayInfo;
            })
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-button" data-action="' . route('admin.accept.currency.edit', ['accept' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::DELETE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 delete-button" data-action="' . route('admin.accept.currency.destroy', ['accept' => $query->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['status', 'action', 'logo', 'payment_gateway'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AcceptCurrency $model): QueryBuilder
    {
        return $model->newQuery()->with('currencyGateway.gatewayInfo');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('accept-currency-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->dom("<'row m-3'<'col-md-3'l><'col-md-5 d-flex align-items-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->parameters([
                'responsive'     => true,
                'autoWidth'      => false,
                'headerCallback' => 'function(thead, data, start, end, display) {
                    $(thead).addClass("bg-primary");
                    $(thead).find("th").addClass("text-white");
                }',
            ])
            ->buttons([
                Button::make('excel')->text('<i class="fa fa-file-excel"></i> Excel')->className('btn btn-success data-table-btn btn-sm-menu'),
                Button::make('csv')->text('<i class="fa fa-file-csv"></i> CSV')->className('btn btn-success data-table-btn btn-sm-menu'),
                Button::make('pdf')->text('<i class="fa fa-file-pdf"></i> PDF')->className('btn btn-success data-table-btn btn-sm-menu'),
                Button::make('print')->text('<i class="fa fa-print"></i> Print')->className('btn btn-success data-table-btn btn-sm-menu')->attr(['target' => '_blank']),
                Button::make('reset')->text('<i class="fa fa-undo-alt"></i> Reset')->className('btn btn-success data-table-btn btn-sm-menu'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::computed('logo')->title(localize('Logo'))->addClass('text-center'),
            Column::make('name')->title(localize('Name')),
            Column::make('symbol')->title(localize('Symbol')),
            Column::computed('payment_gateway')->title(localize('Support Gateway')),
            Column::computed('status')->title(localize('Status'))->orderable(false)->searchable(false),
            Column::make('created_at')->title(localize('Created'))->defaultContent('N/A'),
            Column::computed('action')->title(localize('Action'))
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AcceptCurrency_' . date('YmdHis');
    }

    /**
     * Summary of statusBtn
     * @param mixed $currency
     * @return string
     */
    private function statusBtn($currency): string
    {
        $textColor = "text-warning";
        $status    = "Inactive";

        if ($currency->status == StatusEnum::ACTIVE->value) {
            $textColor = "text-success";
            $status    = "Active";
        }

        return "<strong class='" . $textColor . "'>$status</strong>";
    }

}
