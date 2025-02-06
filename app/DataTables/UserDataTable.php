<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

enum UserEnum {
    const INACTIVE = 0;
    const ACTIVE   = 1;
    const PENDING  = 2;
    const SUSPEND  = 3;
}

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('first_name', function ($query) {
                return $query->first_name . ' ' . $query->last_name;
            })
            ->editColumn('status', function ($query) {
                return $this->statusBtn($query);
            })
            ->editColumn('action', function ($query) {
                return $query->buttonUD(
                    route('edit_users', ['id' => $query->id]),
                    route('delete_users', ['id' => $query->id])
                );
            })
            ->rawColumns(['status', 'action'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->addTableClass('w-100')
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->orderBy(2)
            ->parameters([
                'responsive' => true,
                'autoWidth'  => false,
            ])
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(localize('SL'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('first_name')->title(localize('Name'))->defaultContent('N/A'),
            Column::make('email')->title(localize('Email'))->defaultContent('N/A'),
            Column::make('last_login')->title(localize('Last Login'))->defaultContent('N/A'),
            Column::make('last_logout')->title(localize('Last Logout'))->defaultContent('N/A'),
            Column::computed('status')->title(localize('Status'))->orderable(false)->searchable(false),
            Column::make('created_at')->title(localize('Created')->defaultContent('N/A')),
            Column::make('updated_at')->title(localize('Updated')->defaultContent('N/A')),
            Column::computed('action')->title(localize('Action'))
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }

    /**
     * Summary of statusBtn
     * @param mixed $user
     * @return string
     */
    private function statusBtn($user): string
    {
        $textColor = "text-warning";
        $status    = "Inactive";

        if ($user->status == UserEnum::ACTIVE) {
            $textColor = "text-success";
            $status    = "Active";
        } else
        if ($user->status == UserEnum::PENDING) {
            $textColor = "text-info";
            $status    = "Pending";
        } else {
            $textColor = "text-danger";
            $status    = "Suspend";
        }

        return "<strong class='" . $textColor . "'>$status</strong>";
    }

}
