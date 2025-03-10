<?php

namespace Modules\CMS\DataTables;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HomeAboutTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $button = '<div class="d-flex align-items-center">';

                if ($query->slug == 'home_about') {
                    $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-home-about-button" title="' . localize("Edit") . '" data-action="' . route('admin.cms.home-about.content.update', ['article' => $query->id]) . '" data-route="' . route('admin.cms.home-about.content.edit', ['article' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                if ($query->slug == 'about_us_banner') {
                    $button .= '<a href="javascript:void(0);" class="btn btn-info-soft btn-sm m-1 edit-about-us-banner-button" title="' . localize("Edit") . '" data-action="' . route('admin.cms.home-about.banner.update', ['article' => $query->id]) . '" data-route="' . route('admin.cms.home-about.banner.edit', ['article' => $query->id]) . '"><i class="fa fa-edit"></i></a>';
                }

                $button .= '</div>';

                return $button;
            })
            ->addColumn('button_link', function ($query) {

                if ($query->articleData) {
                    $url = $query->articleData->keyBy('slug')['url']->content ?? null;

                    if ($url) {
                        return '<a target="_blank" href="' . $url . '">' . substr($url, 0, 30) . '</a>';
                    }

                }

                return null;
            })

            ->addColumn('about_image', function ($query) {

                if ($query->articleData) {
                    $image = $query->articleData->keyBy('slug')['image']->content ?? null;

                    if ($image) {
                        return '<img src="' . storage_asset($image) . '" class="dataTable-image-preview" title="' . $query->article_name . '">';
                    }

                }

                return null;
            })
            ->editColumn('updated_at', function ($query) {

                if ($query->updated_at) {
                    return Carbon::parse($query->updated_at)->format('d-m-Y, h:i A');
                }

                return null;
            })
            ->editColumn('status', function ($query) {

                if ($query->status == 1) {
                    return '<span class="text-success">' . localize("Active") . '</span>';
                }

                return '<span class="text-danger">' . localize("Inactive") . '</span>';
            })
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'button_link', 'about_image']);

    }

    public function query(ArticleRepositoryInterface $model): QueryBuilder
    {
        return $model->homeAbout()->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('home-about-table')
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
            Column::make('article_name')->title(localize('Name')),
            Column::make('about_image')->title(localize('About Image')),
            Column::make('updated_at')->title(localize('Updated At')),
            Column::make('status')->title(localize('Status')),
            Column::computed('action')->title(localize('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'HomeAbout_' . date('YmdHis');
    }

}
