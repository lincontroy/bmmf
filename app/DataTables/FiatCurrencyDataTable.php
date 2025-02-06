<?php

namespace App\DataTables;

use App\Enums\CommonStatusEnum;
use App\Repositories\Interfaces\FiatCurrencyRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Enums\AuthGuardEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class FiatCurrencyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d h:i a');
            })
            ->addColumn('status', function ($query) {

                $textColor = "text-warning";
                $status    = enum_ucfirst_case(CommonStatusEnum::INACTIVE->name);

                if ($query->status->value == CommonStatusEnum::ACTIVE->value) {
                    $textColor = "text-success";
                    $status    = enum_ucfirst_case(CommonStatusEnum::ACTIVE->name);
                }

                return "<strong class='" . $textColor . "'>$status</strong>";

            })
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-fiat-currency-button" title="' . localize("Edit") . '" data-action="' . route('admin.currency.fiat.update', ['fiat' => $query->id]) . '" data-route="' . route('admin.currency.fiat.edit', ['fiat' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0);" class="btn btn-danger-soft btn-sm m-1 delete-button" title="' . localize("Delete") . '" data-action="' . route('admin.currency.fiat.destroy', ['fiat' => $query->id]) . '"><i class="fa fa-trash"></i></a>';
                }

                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['status', 'action'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(FiatCurrencyRepositoryInterface $model): QueryBuilder
    {
        return $model->newQuery();
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
            Column::make('name')->title(localize('Name')),
            Column::make('symbol')->title(localize('Symbol')),
            Column::computed('status')->title(localize('Title'))->orderable(false)->searchable(false),
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
        return 'FiatCurrency_' . date('YmdHis');
    }

}
