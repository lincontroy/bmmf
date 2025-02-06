<?php

namespace App\DataTables\Customer;

use App\Enums\CustomerStatusEnum;
use App\Enums\CustomerVerifyStatusEnum;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
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
                $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-data" data-route="' . route(
                    'admin.customers.update',
                    ['customer' => $query->id]
                ) . '"" data-action="' . route('admin.customers.edit', ['customer' => $query->id]
                ) . '""><i class="fa fa-edit"></i></a>';
                $button .= '</div>';

                return $button;
            })
            ->editColumn('user_id', function ($query) {
                return '<a href="' . route('admin.customers.show', ['customer' => $query->id]
                ) . '">' . $query->user_id . '</a>';
            })
            ->editColumn('first_name', function ($query) {
                return $query->first_name . " " . $query->last_name;
            })
            ->editColumn('verified_status', function ($query) {

                if ($query->verified_status->value === CustomerVerifyStatusEnum::VERIFIED->value) {
                    $button = '<span class="badge bg-label-success py-2">' . CustomerVerifyStatusEnum::VERIFIED->name . '</span>';
                } else {

                    if ($query->verified_status->value === CustomerVerifyStatusEnum::PROCESSING->value) {
                        $button = '<a href="#" class="badge bg-label-primary py-2"><span class="spinner-dotted me-2" role="status"> </span><span>' . CustomerVerifyStatusEnum::PROCESSING->name . '</span></a>';
                    } else {

                        if ($query->verified_status->value === CustomerVerifyStatusEnum::CANCELED->value) {
                            $button = '<span class="badge bg-label-danger py-2">' . CustomerVerifyStatusEnum::CANCELED->name . '</span>';
                        } else {
                            $button = '<span class="badge bg-label-warning py-2">' . str_replace('_', ' ', CustomerVerifyStatusEnum::NOT_SUBMIT->name) .
                                '</span>';
                        }

                    }

                }

                return $button;
            })
            ->editColumn('status', function ($query) {

                if ($query->status->value === CustomerStatusEnum::ACTIVE->value) {
                    $button = '<span class="badge bg-label-success py-2 w-px-75">' . CustomerStatusEnum::ACTIVE->name . '</span>';
                } else {

                    if ($query->status->value === CustomerStatusEnum::DEACTIVE->value) {
                        $button = '<span class="badge bg-label-warning py-2 w-px-75">' . CustomerStatusEnum::DEACTIVE->name . '</span>';
                    } else {

                        if ($query->status->value === CustomerStatusEnum::PENDING->value) {
                            $button = '<span class="badge bg-label-warning py-2 w-px-75">' . CustomerStatusEnum::PENDING->name . '</span>';
                        } else {
                            $button = '<span class="badge bg-label-danger py-2 w-px-75">' . CustomerStatusEnum::SUSPEND->name .
                                '</span>';
                        }

                    }

                }

                return $button;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status', 'user_id', 'action', 'verified_status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "customer-tbl";

        return $this->builder()
            ->setTableId($tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->dom(
                "<'row m-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>"
            )
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
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass(
                'text-center'
            ),
            Column::make('user_id')->title(localize('User ID'))->addClass('text-center'),
            Column::make('first_name')->title(localize('Name')),
            Column::make('email')->title(localize('Email')),
            Column::make('phone')->title(localize('Phone')),
            Column::make('referral_user')->title(localize('Referral User')),
            Column::make('verified_status')->title(localize('Verified Status')),
            Column::make('status')->title(localize('Status')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->title(localize('Action'))
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'customers' . date('YmdHis');
    }

}
