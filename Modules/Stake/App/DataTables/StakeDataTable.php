<?php

namespace Modules\Stake\App\DataTables;

use App\Enums\AuthGuardEnum;
use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Stake\App\Models\StakePlan;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StakeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('stake_name', function ($stakePlan) {
                $imageLink = $stakePlan->acceptCurrency->logo ? assets('img/' . $stakePlan->acceptCurrency->logo) : assets('img/blank50x50.png');
                return '<div class="fee-coin rounded-circle"><img src="' . $imageLink . '" alt=""> ' . $stakePlan->stake_name . '</div> ';
            })
            ->addColumn('rates', function ($stakeRates) {
                $ratesInfo = '<div class="d-flex align-items-center gap-2">';

                foreach ($stakeRates->stakeRateInfo as $key => $value) {
                    $ratesInfo .= '<span class="bg-primary p-1 fs-15 text-white rounded-2">' . $value->rate . '%</span>';
                }

                $ratesInfo .= '</div>';

                return $ratesInfo;
            })
            ->addColumn('duration', function ($stakeRates) {
                $ratesInfo = '<div class="d-flex align-items-center gap-2">';

                foreach ($stakeRates->stakeRateInfo as $key => $value) {
                    $ratesInfo .= '<span class="bg-primary p-1 fs-15 text-white rounded-2">' . $value->duration . ' days</span>';
                }

                $ratesInfo .= '</div>';

                return $ratesInfo;
            })
            ->addColumn('price', function ($stakeRates) {
                $ratesInfo = '<div class="d-flex align-items-center gap-2">';

                foreach ($stakeRates->stakeRateInfo as $key => $value) {
                    $ratesInfo .= '<span class="bg-primary p-1 fs-15 text-white rounded-2">' . $value->min_amount . ' - ' . $value->max_amount . ' ' . $stakeRates->acceptCurrency->symbol . '</span>';
                }

                $ratesInfo .= '</div>';

                return $ratesInfo;
            })
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::UPDATE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-navy d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 edit-button" data-action="' . route('stake.edit', ['stake' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if (auth(AuthGuardEnum::ADMIN->value)->user()->can(PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::DELETE->value)) {
                    $button .= '<a href="javascript:void(0)" class="btn btn-red d-flex align-items-center justify-content-center py-2 rounded-3 w-px-40 m-1 delete-button" data-action="' . route('stake.destroy', ['stake' => $query->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }

                $button .= '</div>';
                return $button;
            })
            ->editColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->editColumn('created_at', function ($query) {
                return get_ymd($query->created_at);
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['status', 'stake_name', 'rates', 'duration', 'price', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(StakePlan $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc')
            ->with('acceptCurrency')->with('stakeRateInfo');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $tableId = "stake-table";
        return $this->builder()
            ->setTableId($tableId)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
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
            Column::computed('stake_name')->title(localize('Plan Name'))->width(250),
            Column::computed('rates')->title(localize('Interest (%)')),
            Column::computed('duration')->title(localize('Duration (days)')),
            Column::computed('price')->title(localize('Prices')),
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
        return 'Packages_' . date('YmdHis');
    }

    private function statusBtn($query): string
    {
        $textLabel = "danger";
        $status    = "Inactive";

        if ($query->status->value == StatusEnum::ACTIVE->value) {
            $textLabel = "success";
            $status    = "Active";
        }

        return '<span class="badge bg-label-' . $textLabel . ' py-2 w-px-100">' . $status . '</span>';
    }

}
