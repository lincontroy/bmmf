<?php

namespace Modules\Merchant\DataTables;

use App\Enums\AuthGuardEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Merchant\App\Enums\MerchantPaymentUlrStatusEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentUrlRepositoryInterface;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MerchantPaymentUrlTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-payment-url-button" title="' . localize("Edit") . '" data-action="' . route('customer.merchant.payment-url.update', ['payment_url' => $query->id]) . '" data-route="' . route('customer.merchant.payment-url.edit', ['payment_url' => $query->id]) . '"><i class="fa fa-edit"></i></a>';

                $button .= '<a href="javascript:void(0);" class="btn btn-danger-soft btn-sm m-1 delete-button" title="' . localize("Delete") . '" data-action="' . route('customer.merchant.payment-url.destroy', ['payment_url' => $query->id]) . '"><i class="fa fa-trash"></i></a>';

                $button .= '</div>';

                return $button;
            })
            ->addColumn('link', function ($query) {
                return ' <a href="javascript:void(0);" type="button" class="d-flex gap-2 text-warning view-payment-link" data-action="' . route('customer.merchant.payment-url.view-payment-link', ['payment_url' => $query->id]) . '"
                >
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3.66667 3.66667H9.16667V9.16667H3.66667V3.66667ZM18.3333 3.66667V9.16667H12.8333V3.66667H18.3333ZM12.8333 13.75H14.6667V11.9167H12.8333V10.0833H14.6667V11.9167H16.5V10.0833H18.3333V11.9167H16.5V13.75H18.3333V16.5H16.5V18.3333H14.6667V16.5H11.9167V18.3333H10.0833V14.6667H12.8333V13.75ZM14.6667 13.75V16.5H16.5V13.75H14.6667ZM3.66667 18.3333V12.8333H9.16667V18.3333H3.66667ZM5.5 5.5V7.33333H7.33333V5.5H5.5ZM14.6667 5.5V7.33333H16.5V5.5H14.6667ZM5.5 14.6667V16.5H7.33333V14.6667H5.5ZM3.66667 10.0833H5.5V11.9167H3.66667V10.0833ZM8.25 10.0833H11.9167V13.75H10.0833V11.9167H8.25V10.0833ZM10.0833 5.5H11.9167V9.16667H10.0833V5.5ZM1.83333 1.83333V5.5H0V1.83333C0 1.3471 0.193154 0.880788 0.536971 0.536971C0.880788 0.193154 1.3471 0 1.83333 0L5.5 0V1.83333H1.83333ZM20.1667 0C20.6529 0 21.1192 0.193154 21.463 0.536971C21.8068 0.880788 22 1.3471 22 1.83333V5.5H20.1667V1.83333H16.5V0H20.1667ZM1.83333 16.5V20.1667H5.5V22H1.83333C1.3471 22 0.880788 21.8068 0.536971 21.463C0.193154 21.1192 0 20.6529 0 20.1667V16.5H1.83333ZM20.1667 20.1667V16.5H22V20.1667C22 20.6529 21.8068 21.1192 21.463 21.463C21.1192 21.8068 20.6529 22 20.1667 22H16.5V20.1667H20.1667Z"
                            fill="#F7931A" />
                    </svg>
                    <span>' . localize('View Link') . '</span>
                </a>';

            })
            ->editColumn('amount', function ($query) {
                return ($query->fiatCurrency->symbol ?? null) . ' ' . number_format($query->amount, 2);
            })
            ->editColumn('payment_type', function ($query) {
                return enum_ucfirst_case($query->payment_type->name);
            })
            ->editColumn('status', function ($query) {
                if ($query->status->value === MerchantPaymentUlrStatusEnum::ACTIVE->value) {
                    return ' <span class="badge bg-label-success py-2 w-px-100">' . enum_ucfirst_case($query->status->name) . '</span>';
                }
                return ' <span class="badge bg-label-warning py-2 w-px-100">' . localize('Expired') . '</span>';
            })
            ->editColumn('duration', function ($query) {
                return $query->duration->format('F d, Y H:i A');
            })
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('F d, Y H:i A');
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'link', 'status']);

    }

    public function query(MerchantPaymentUrlRepositoryInterface $model): QueryBuilder
    {
        return $model->merchantPaymentUrlTable(['user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id])->newQuery()->orderBy('id', 'desc');
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
            Column::make('title')->title(localize('Store Name')),
            Column::make('amount')->title(localize('Amount')),
            Column::make('link')->title(localize('Link')),
            Column::make('status')->title(localize('Status')),
            Column::make('created_at')->title(localize('Created At')),
            Column::make('duration')->title(localize('Duration')),
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
