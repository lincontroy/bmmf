<?php

namespace App\DataTables\Customer\earning;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MyGenerationDataTable extends DataTable
{
    public function dataTable(EloquentBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['id']);
    }

    public function query(Customer $model): EloquentBuilder
    {
        $userId = Auth::user()->user_id;
        $data = $this->getTeamData($userId);

        // Create a temporary table and insert data into it
        DB::statement('
            CREATE TEMPORARY TABLE temp_team_data (
                id INT AUTO_INCREMENT PRIMARY KEY,
                level INT,
                user_id VARCHAR(255),
                username VARCHAR(255),
                name VARCHAR(255),
                referral_user VARCHAR(255)
            )
        ');
        DB::table('temp_team_data')->insert($data);

        // Query the temporary table using a Customer model to get an EloquentBuilder
        return Customer::select('temp_team_data.*')
                       ->from('temp_team_data')
                       ->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('transaction-table')
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
            Column::make('id')->title(localize('id')),
        ];
    }

    protected function filename(): string
    {
        return 'Transaction_' . date('YmdHis');
    }

    private function getTeamData($user_id)
    {
        $data = [];
        $level_one =  DB::table('customers')->where('user_id', $user_id)->get();
        $this->processLevel($level_one, $data, 1);

        return $data; // Return the array directly
    }

    private function processLevel($users, &$data, $level)
    {
        foreach ($users as $user) {
            $data[] = [
                'level' => $level,
                'user_id' => $user->user_id,
                'username' => $user->username,
                'name' => $user->first_name . ' ' . $user->last_name,
                'referral_user' => $user->referral_user,
            ];

            $next_level_users = DB::table('customers')->where('referral_user', $user->user_id)->get();
            if ($next_level_users->isNotEmpty()) {
                $this->processLevel($next_level_users, $data, $level + 1);
            }
        }
    }
}
