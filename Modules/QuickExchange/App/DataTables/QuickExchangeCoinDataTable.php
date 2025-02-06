<?php

namespace Modules\QuickExchange\App\DataTables;

use App\Enums\AuthGuardEnum;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\QuickExchange\App\Models\QuickExchangeCoin;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QuickExchangeCoinDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('logo', function ($quickExchangeCoinInfo) {
                $imageLink = $quickExchangeCoinInfo->image ? assets("img/crypto/" . $quickExchangeCoinInfo->image) : assets('img/blank50x50.png');
                return '<div class="fee-coin rounded-circle"><img src="' . $imageLink . '" alt=""></div>';
            })
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-button" data-action="' . route('quickexchange.edit', ['quickexchange' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::DELETE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 delete-button" data-action="' . route('quickexchange.destroy', ['quickexchange' => $query->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';
                return $button;
            })
            ->addColumn('reserve_balance', function ($query) {
                return number_format($query->reserve_balance, 4, '.', '') . ' ' . $query->symbol;
            })
            ->addColumn('minimum_tx_amount', function ($query) {
                return number_format($query->minimum_tx_amount, 4, '.', '') . ' ' . $query->symbol;
            })
            ->editColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status', 'logo', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(QuickExchangeCoin $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "quick_exchange_coin_table";
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
            Column::computed('logo')->title(localize('Coin Icon'))->searchable(false)->orderable(false)->addClass('text-center'),
            Column::make('coin_name')->title(localize('Coin Name')),
            Column::make('symbol')->title(localize('Symbol')),
            Column::computed('reserve_balance')->title(localize('Reserve')),
            Column::computed('minimum_tx_amount')->title(localize('Min. Txn Amount')),
            Column::make('status')->title(localize('Status')),
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
        return 'QuickExchangeCoin_' . date('YmdHis');
    }

    private function statusBtn($query): string
    {
        $textLabel = "danger";
        $status    = "Inactive";

        if ($query->status == StatusEnum::ACTIVE->value) {
            $textLabel = "success";
            $status    = "Active";
        }

        return '<span class="badge bg-label-' . $textLabel . ' py-2 w-px-100">' . $status . '</span>';
    }

}
