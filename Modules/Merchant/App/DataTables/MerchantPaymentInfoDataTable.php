<?php

namespace Modules\Merchant\App\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Merchant\App\Enums\MerchantPaymentInfoStatusEnum;
use Modules\Merchant\App\Models\MerchantPaymentInfo;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MerchantPaymentInfoDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $tab = $this->request->get('workStatus');

        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                if (
                    $query->status->value != MerchantPaymentInfoStatusEnum::CANCELED->value && $query->status->value
                    != MerchantPaymentInfoStatusEnum::COMPLETE->value
                ) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeStatus" action-type="confirm" title="' . localize("Complete") . '" data-action="' . route('admin.merchant.transactions.update', ['merchant_transaction' => $query->id, 'set_status' => MerchantPaymentInfoStatusEnum::COMPLETE->value]) . '"><i class="fa fa-check"></i></a>';
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 changeStatus" action-type="cancel" title="' . localize("Cancel") . '" data-action="' . route('admin.merchant.transactions.update', ['merchant_transaction' => $query->id, 'set_status' => MerchantPaymentInfoStatusEnum::CANCELED->value]) . '"><i class="fa fa-ban" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';
                return $button;
            })
            ->editColumn('merchant_customer_info_id', function ($query) {

                if (!empty($query->merchantAccountInfo)) {
                    $imgLink = $query->merchantAccountInfo->logo ? storage_asset($query->merchantAccountInfo->logo) : assets('img/noimage.jpg');
                    return '<div class="d-flex align-items-center gap-3">
                                      <div class="user-img rounded-circle">
                                        <img width="80" height="80" src="' . $imgLink . '" alt="">
                                        </div>
                                      <div>
                                        <p class="mb-1 fs-15 fw-medium">' . $query->merchantAccountInfo->store_name . '</p>
                                        <p class="mb-0 fs-12 fw-normal">' . $query->merchantAccountInfo->email . '</p>
                                      </div>
                                    </div>';
                }

                return null;
            })
            ->addColumn('merchant_account_id', function ($query) {

                if (!empty($query->merchantCustomerInfo)) {
                    return $query->merchantCustomerInfo->email . '<br>' . $query->merchantCustomerInfo->first_name . " " .
                        $query->merchantCustomerInfo->last_name;
                }

                return null;
            })
            ->addColumn('merchant_accepted_coin', function ($query) {
                $imgLink = isset($query->merchantCoinInfo->logo) ? assets('img/' . $query->merchantCoinInfo->logo) : assets('img/noimage.jpg');
                return '<img width="40" height="40" src="' . $imgLink . '" alt="">';
            })
            ->addColumn('payment_gateway_id', function ($query) {
                return $query->merchantGatewayInfo->name;
            })
            ->addColumn('amount', function ($query) {
                $acceptCoin = isset($query->merchantCoinInfo->symbol) ? $query->merchantCoinInfo->symbol : null;
                return $query->amount.' '.$acceptCoin;
            })
            ->addColumn('received_amount', function ($query) {
                $acceptCoin = isset($query->merchantCoinInfo->symbol) ? $query->merchantCoinInfo->symbol : null;
                return $query->received_amount.' '.$acceptCoin;
            })
            ->addColumn('transaction_hash', function ($query) {
                return '<div class="d-flex align-items-center gap-3"><p class="mb-1 fs-15 fw-medium w-px-160 text-truncate transactionHash">'
                . $query->merchantPaymentTransaction->transaction_hash . '</p>
                <img class="copy" src="' . assets('img/copy.svg') . '" alt=""></div>';
            })
            ->addColumn('payment_gateway_id', function ($query) {
                return $query->merchantGatewayInfo->name;
            })
            ->addColumn('created_at', function ($query) {

                $date1 = date_create($query->created_at);
                $date2 = date_create(Carbon::now());
                $diff  = date_diff($date1, $date2);
                $hours = $diff->days * 24 + $diff->h . ' Hours ago';
                return '<p class="mb-1 fs-15 fw-medium w-px-160">'
                . $hours . '</p>' . get_jsmy_date($query->created_at);
            })
            ->editColumn('status', function ($query) {

                if ($query->status->value == MerchantPaymentInfoStatusEnum::PENDING->value) {
                    $status = '<span class="badge bg-label-warning py-2 w-px-75">' .
                    MerchantPaymentInfoStatusEnum::PENDING->name . '</span>';
                } else

                if ($query->status->value == MerchantPaymentInfoStatusEnum::COMPLETE->value) {
                    $status = '<span class="badge bg-label-success py-2 w-px-75">' .
                    MerchantPaymentInfoStatusEnum::COMPLETE->name . '</span>';
                } else {
                    $status = '<span class="badge bg-label-danger py-2 w-px-75">' .
                    MerchantPaymentInfoStatusEnum::CANCELED->name . '</span>';
                }

                return $status;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'merchant_customer_info_id', 'merchant_accepted_coin', 'merchant_account_id', 'transaction_hash', 'created_at',
                'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MerchantPaymentInfo $model): QueryBuilder
    {
        $tab                  = $this->request->get('workStatus');
        $attributes['status'] = '';

        if ($tab == "pending") {
            $attributes['status'] = MerchantPaymentInfoStatusEnum::PENDING->value;
        } else

        if ($tab == "confirm") {
            $attributes['status'] = MerchantPaymentInfoStatusEnum::COMPLETE->value;
        } else

        if ($tab == "canceled") {
            $attributes['status'] = MerchantPaymentInfoStatusEnum::CANCELED->value;
        }

        return $this->baseQuery($model, $attributes)->with(['merchantAccountInfo', 'merchantCustomerInfo', 'merchantCoinInfo', 'merchantGatewayInfo', 'merchantPaymentTransaction']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function baseQuery($model, $attributes = []): QueryBuilder
    {
        $query = $model->newQuery();

        if (!empty($attributes['status'])) {
            $query->where('status', $attributes['status']);
        }

        $query->orderBy('id', 'desc');

        return $query;

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = 'merchant-payment-info-table';
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
            Column::make('merchant_customer_info_id')->title(localize('User')),
            Column::make('merchant_account_id')->title(localize('Customer')),
            Column::make('merchant_accepted_coin')->title(localize('Coin')),
            Column::make('payment_gateway_id')->title(localize('Method')),
            Column::make('transaction_hash')->title('Address'),
            Column::computed('amount')->title(localize('Amount')),
            Column::computed('received_amount')->title(localize('Received Amount')),
            Column::make('created_at')->title(localize('Created')),
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
