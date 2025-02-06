<?php

namespace Modules\Merchant\DataTables;

use App\Enums\AuthGuardEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAccountRepositoryInterface;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Modules\Merchant\App\Enums\MerchantApplicationStatusEnum;

class MerchantAccountTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '</div>';

                return $button;
            })
            ->editColumn('status', function ($query) {

                if ($query->status == MerchantApplicationStatusEnum::APPROVED) {
                    return ' <span class="badge bg-label-success py-2 w-px-100">' . enum_ucfirst_case($query->status->name) . '</span>';
                }
                elseif ($query->status == MerchantApplicationStatusEnum::PENDING) {
                    return ' <span class="badge bg-label-warning py-2 w-px-100">' . enum_ucfirst_case($query->status->name) . '</span>';
                }
                elseif ($query->status == MerchantApplicationStatusEnum::SUSPEND) {
                    return ' <span class="badge bg-label-danger py-2 w-px-100">' . enum_ucfirst_case("Rejected") . '</span>';
                }

                return ' <span class="badge bg-label-warning py-2 w-px-100">' . enum_ucfirst_case($query->status->name) . '</span>';
            })
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('F d, Y H:i A');
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status']);

    }

    public function query(MerchantAccountRepositoryInterface $model): QueryBuilder
    {
        return $model->queryByAttributes(['user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id])->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('merchant-payment-url-table')
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('store_name')->title(localize('Store Name')),
            Column::make('email')->title(localize('Email')),
            Column::make('phone')->title(localize('Phone')),
            Column::make('status')->title(localize('Status')),
            Column::make('created_at')->title(localize('Created At')),
            Column::computed('action')->title(localize('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Merchant_Payment_Url_' . date('YmdHis');
    }

}
