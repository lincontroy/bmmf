<?php

namespace Modules\Reports\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Modules\Reports\App\DataTables\FeesHistoryDataTable;
use Modules\Reports\App\DataTables\InvestmentHistoryDataTable;
use Modules\Reports\App\DataTables\LoginHistoryDataTable;
use Modules\Reports\App\DataTables\TransactionsLoagsDataTable;

class ReportsController extends Controller
{

    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct()
    {
        $this->mapActionPermission = [
            'index'             => PermissionMenuEnum::REPORTS_TRANSACTION->value . '.' . PermissionActionEnum::READ->value,
            'investmentHistory' => PermissionMenuEnum::REPORTS_INVESTMENT->value . '.' . PermissionActionEnum::READ->value,
            'feesHistory'       => PermissionMenuEnum::REPORTS_FEES->value . '.' . PermissionActionEnum::READ->value,
            'loginHistory'      => PermissionMenuEnum::REPORTS_LOGIN_HISTORY->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TransactionsLoagsDataTable $transactionsLoagsDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Transactions Logs'),
            'description' => localize('Transactions Logs'),
        ]);

        return $transactionsLoagsDataTable->render('reports::index');
    }

    /**
     * Display a listing of the resource.
     */
    public function investmentHistory(InvestmentHistoryDataTable $investmentHistoryDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Investment History'),
            'description' => localize('Investment History'),
        ]);

        return $investmentHistoryDataTable->render('reports::investment_history');
    }

    /**
     * Display a listing of the resource.
     */
    public function feesHistory(FeesHistoryDataTable $feesHistoryDataTable)
    {
        cs_set('theme', [
            'title'       => localize('fees_history'),
            'description' => localize('fees_history'),
        ]);
        return $feesHistoryDataTable->render('reports::fees_history');
    }

    /**
     * Display a listing of the resource.
     */
    public function loginHistory(LoginHistoryDataTable $loginHistoryDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Login History'),
            'description' => localize('Login History'),
        ]);

        return $loginHistoryDataTable->render('reports::login_history');
    }

}
