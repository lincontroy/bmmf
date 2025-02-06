<?php

namespace Modules\Merchant\App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Merchant\App\Enums\MerchantApplicationStatusEnum;
use Modules\Merchant\App\Models\MerchantAccount;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MerchantApplicationDataTable extends DataTable
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

                if ($query->status->value != MerchantApplicationStatusEnum::APPROVED->value) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeStatus" action-type="confirm" title="' . localize(
                            "Approve"
                        ) . '" data-action="' . route(
                            'admin.merchant.account.update',
                            ['merchant' => $query->id, 'set_status' => MerchantApplicationStatusEnum::APPROVED->value]
                        ) . '"><i class="fa fa-check"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="btn btn-warning text-white d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeStatus" action-type="reject" title="' . localize(
                            "Reject"
                        ) . '" data-action="' . route(
                            'admin.merchant.account.update',
                            ['merchant' => $query->id, 'set_status' => MerchantApplicationStatusEnum::SUSPEND->value]
                        ) . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeStatus" action-type="suspend" title="' . localize(
                            "Suspend"
                        ) . '" data-action="' . route(
                            'admin.merchant.account.update',
                            ['merchant' => $query->id, 'set_status' => MerchantApplicationStatusEnum::SUSPEND->value]
                        ) . '"><i class="fa fa-ban" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';

                return $button;
            })
            ->editColumn('id', function ($query) {
                return $query->customerInfo['user_id'];
            })
            ->editColumn('created_at', function ($query) {
                return get_ymd($query->created_at);
            })
            ->editColumn('user_id', function ($query) {
                return $query->customerInfo['first_name'] . " " . $query->customerInfo['last_name'];
            })
            ->addColumn('logo', function ($query) {
                $imgLink = $query->logo ? storage_asset($query->logo) : assets('img/noimage.jpg');

                return '<img width="60" height="60" src="' . $imgLink . '" alt="">';
            })
            ->editColumn('status', function ($query) {
                return '<span class="badge bg-label-warning py-2 w-px-75">' . MerchantApplicationStatusEnum::PENDING->name . '</span>';
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'logo', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MerchantAccount $model): QueryBuilder
    {
        $attributes['status'] = MerchantApplicationStatusEnum::PENDING->value;

        return $this->baseQuery($model, $attributes)->with('customerInfo');
    }

    /**
     * Get the query source of dataTable.
     */
    public function baseQuery($model, $attributes = []): QueryBuilder
    {
        $query = $model->newQuery();

        if (!empty($attributes['status'])) {
            $query->where('status', MerchantApplicationStatusEnum::PENDING->value);
        }

        $query->orderBy('id', 'desc');

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'merchant-application-table';

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
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(
                30
            )->addClass('text-center'),
            Column::make('id')->title(localize('User ID')),
            Column::make('created_at')->title(localize('Date')),
            Column::make('user_id')->title(localize('User')),
            Column::make('store_name')->title(localize('Store')),
            Column::make('email')->title(localize('Email')),
            Column::make('phone')->title(localize('Phone')),
            Column::make('website_url')->title(localize('Website Url')),
            Column::make('logo')->title(localize('Logo')),
            Column::make('about')->title(localize('About')),
            Column::make('status')->title(localize('Status'))->addClass('text-center'),
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
        return 'Deposits_' . date('YmdHis');
    }

}
