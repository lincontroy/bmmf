<?php

namespace Modules\Package\App\Services;

use App\Enums\StatusEnum;
use App\Http\Resources\ArticleLangResource;
use App\Http\Resources\ManyArticlesResource;
use App\Http\Resources\PackageResource;
use App\Repositories\Eloquent\AcceptCurrencyRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CommissionSetupRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\InvestmentDetailsRepositoryInterface;
use App\Repositories\Interfaces\InvestmentEarningRepositoryInterface;
use App\Repositories\Interfaces\InvestmentRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use App\Repositories\Interfaces\WalletTransactionLogRepositoryInterface;
use App\Services\NotificationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Enums\InterestTypeEnum;
use Modules\Package\App\Enums\InvestTypeEnum;
use Modules\Package\App\Enums\ReturnTypeEnum;
use Modules\Package\App\Repositories\Eloquent\EarningRepository;
use Modules\Package\App\Repositories\Eloquent\UserLevelRepository;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\TeamBonusDetailsRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\TeamBonusRepositoryInterface;

class TeamBonusService
{
    /**
     * TeamBonusService constructor.
     *
     */
    public function __construct(
        private TeamBonusRepositoryInterface $teamBonusRepository,
    ) {
    }

    public function report($userId = '', $type = ''): object
    {
        $totalTxnAmount       = $this->teamBonusRepository->totalData($userId, $type);
        $currentMonthData     = $this->teamBonusRepository->sumCurrentMonthData($userId, $type);
        $previousMonthData    = $this->teamBonusRepository->sumPreviousMonthData($userId, $type);
        $percentageDifference = $previousMonthData > 0 ? ($currentMonthData - $previousMonthData) / $previousMonthData * 100 :
            ($currentMonthData - $previousMonthData > 0 ? 100 : 0);

        return (object) [
            'totalTeamTurnOverAmount'   => number_format($totalTxnAmount, 2, '.', ''),
            'currentMonthData'          => number_format($currentMonthData, 2, '.', ''),
            'previousMonthData'         => number_format($previousMonthData, 2, '.', ''),
            'percentageDifference'      => number_format($percentageDifference, 2, '.', ''),
        ];
    }
  
    /**
     * Fetch yearly tea turnover chart data
     * @return object
     */
    public function teamTurnoverChartData(string $userId, string $txnType): object
    {
        $chartYearData = $this->teamBonusRepository->sumYearlyChartData($userId, $txnType);

        return (object)[
            'abbreviateMonthNames' => getAbbreviatedMonthNames(),
            'chartYearData'        => $chartYearData,
        ];
    }
}
