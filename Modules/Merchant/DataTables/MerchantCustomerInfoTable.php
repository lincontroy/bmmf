<?php

namespace Modules\Merchant\DataTables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Merchant\App\Repositories\Interfaces\MerchantCustomerInfoRepositoryInterface;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Enums\AuthGuardEnum;

class MerchantCustomerInfoTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-customer-button" title="'.localize("Edit").'" data-action="' . route('customer.merchant.customer.update', ['customer' => $query->id]) . '" data-route="' . route('customer.merchant.customer.edit', ['customer' => $query->id]) . '"><i class="fa fa-edit"></i></a>';

                $button .= '</div>';

                return $button;
            })
            ->editColumn('email', function ($query) {
                $button = '<div class="d-flex gap-3">
                    <p class="mb-1 w-px-160 text-truncate" >'.$query->email.'</p>
                    <span class="copy-value" data-copyvalue="'.$query->email.'">
                        <svg  width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M10.4615 4.00504e-07H7.13321C5.6253 -1.72739e-05 4.43093 -2.61657e-05 3.49619 0.135333C2.5342 0.274625 1.75558 0.568127 1.14153 1.22947C0.527492 1.89082 0.254983 2.72943 0.125654 3.76552C-2.41964e-05 4.77226 -1.60384e-05 6.05863 3.71821e-07 7.68269V13.0349C3.71821e-07 14.6894 1.12579 16.0607 2.59734 16.3088C2.71055 16.984 2.9272 17.5602 3.36275 18.0294C3.85663 18.5613 4.47847 18.7901 5.21703 18.897C5.92839 19 6.83282 19 7.95495 19H10.5066C11.6287 19 12.5332 19 13.2446 18.897C13.9831 18.7901 14.6049 18.5613 15.0988 18.0294C15.5927 17.4974 15.8051 16.8277 15.9044 16.0323C16 15.2661 16 14.292 16 13.0834V8.56776C16 7.35922 16 6.38508 15.9044 5.61892C15.8051 4.82347 15.5927 4.15373 15.0988 3.6218C14.6632 3.1527 14.1282 2.91935 13.5013 2.79743C13.271 1.21251 11.9977 4.00504e-07 10.4615 4.00504e-07ZM12.2087 2.66987C11.9602 1.88783 11.2719 1.32558 10.4615 1.32558H7.17949C5.61492 1.32558 4.50339 1.32699 3.66018 1.44909C2.83468 1.56862 2.35907 1.7928 2.01182 2.1668C1.66457 2.5408 1.45643 3.05304 1.34544 3.94215C1.23207 4.85031 1.23077 6.04746 1.23077 7.73256V13.0349C1.23077 13.9076 1.75281 14.649 2.47891 14.9166C2.46152 14.3776 2.46153 13.7681 2.46154 13.0834V8.56776C2.46152 7.35922 2.46151 6.38508 2.55714 5.61892C2.65644 4.82347 2.86887 4.15373 3.36275 3.6218C3.85663 3.08987 4.47847 2.86108 5.21703 2.75413C5.92839 2.65113 6.83282 2.65115 7.95495 2.65116H10.5066C11.1423 2.65115 11.7082 2.65115 12.2087 2.66987ZM4.23303 4.55913C4.46012 4.31455 4.77895 4.15508 5.38102 4.0679C6.0008 3.97815 6.82224 3.97674 8 3.97674H10.4615C11.6393 3.97674 12.4607 3.97815 13.0805 4.0679C13.6826 4.15508 14.0014 4.31455 14.2285 4.55913C14.4556 4.8037 14.6037 5.1471 14.6846 5.79555C14.7679 6.46307 14.7692 7.34777 14.7692 8.61628V13.0349C14.7692 14.3034 14.7679 15.1881 14.6846 15.8556C14.6037 16.5041 14.4556 16.8474 14.2285 17.092C14.0014 17.3367 13.6826 17.4961 13.0805 17.5833C12.4607 17.673 11.6393 17.6744 10.4615 17.6744H8C6.82224 17.6744 6.0008 17.673 5.38102 17.5833C4.77895 17.4961 4.46012 17.3367 4.23303 17.092C4.00595 16.8474 3.85789 16.5041 3.77694 15.8556C3.69361 15.1881 3.69231 14.3034 3.69231 13.0349V8.61628C3.69231 7.34777 3.69361 6.46307 3.77694 5.79555C3.85789 5.1471 4.00595 4.8037 4.23303 4.55913Z"
                            fill="#6C6C6C"
                        ></path>
                        </svg>
                    </span>
              </div>';

                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'email']);

    }

    public function query(MerchantCustomerInfoRepositoryInterface $model): QueryBuilder
    {

        return $model->merchantCustomerInfoTable(['user_id' => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id])->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('merchant-customer-table')
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
            Column::make('first_name')->title(localize('First Name')),
            Column::make('last_name')->title(localize('Last Name')),
            Column::make('email')->title(localize('Email')),
            Column::computed('action')->title(localize('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Merchant_Customer_' . date('YmdHis');
    }

}
