<?php

namespace App\DataTables;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LanguagesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '<a href="' . route('admin.setting.language.build.index', ['language' => $query->id]) . '" class="btn btn-info-soft btn-sm m-1" title="'.localize("Builder").'"><i class="fa fa-solid fa-flag"></i></a>';

                $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-language-button" title="'.localize("Edit").'" data-action="' . route('admin.setting.language.update', ['language' => $query->id]) . '" data-route="' . route('admin.setting.language.edit', ['language' => $query->id]) . '"><i class="fa fa-edit"></i></a>';

                $button .= '<a href="javascript:void(0);" class="btn btn-danger-soft btn-sm m-1 delete-button" title="'.localize("Delete").'" data-action="' . route('admin.setting.language.destroy', ['language' => $query->id]) . '"><i class="fa fa-trash"></i></a>';

                $button .= '</div>';

                return $button;
            })
            ->editColumn('logo', function ($query) {

                if ($query->logo) {
                    return '<img width="60" height="60" src="' . storage_asset($query->logo) . '" class="dataTable-image-preview" title="'.localize("Language Logo").'">';
                }

                return null;
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'logo']);

    }

    public function query(Language $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('languages-table')
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
            Column::make('name')->title(localize('Name')),
            Column::make('symbol')->title(localize('Symbol')),
            Column::make('logo')->title(localize('Logo'))->addClass('text-center'),
            Column::computed('action')->title(localize('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Languages_' . date('YmdHis');
    }

}
