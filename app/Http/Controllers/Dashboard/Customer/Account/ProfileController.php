<?php

namespace App\Http\Controllers\Dashboard\Customer\Account;

use App\Enums\AuthGuardEnum;
use App\Enums\NotificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerUpdateSiteAlignRequest;
use App\Services\CustomerDashboardService;
use App\Services\CustomerService;
use App\Services\NotificationService;
use App\Services\TxnReportService;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Package\App\Repositories\Interfaces\TeamBonusRepositoryInterface;
use Modules\Package\App\Services\PackageService;
use Modules\Stake\App\Services\StakePlanService;

class ProfileController extends Controller
{
    use ResponseTrait;

    /**
     * ProfileController of __construct
     *
     * @param PackageService $packageService
     * @param CustomerDashboardService $customerDashboardService
     */
    public function __construct(
        protected PackageService $packageService,
        protected StakePlanService $stakePlanService,
        protected CustomerDashboardService $customerDashboardService,
        private TxnReportService $txnReportService,
        private CustomerService $customerService,
        private NotificationService $notificationService,
        private TeamBonusRepositoryInterface $teamBonusRepository,
    ) {
    }

    /**
     * Index
     *
     * @return View
     */
    public function profile(): View
    {
        cs_set('theme', [
            'title'       => localize('Customer Profile'),
            'description' => localize('Customer Profile'),
        ]);

        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        $this->notificationService->readNotification(['status' => NotificationEnum::UNREAD, 'customer_id' => $customer->id]);

        $data                  = [];
        $data['customer']      = $customer;
        $data['award']         = $this->teamBonusRepository->firstWhere('user_id', $customer->user_id);
        $data['notifications'] = $this->notificationService->notificationPaginate(['customer_id' => $customer->id]);

        return view('customer.account.profile', $data);
    }

    /**
     * Update Customer Site Align
     *
     * @param CustomerUpdateSiteAlignRequest $request
     * @return RedirectResponse
     */
    public function update_site_align(CustomerUpdateSiteAlignRequest $request): RedirectResponse
    {
        $data                = $request->validated();
        $data['customer_id'] = auth(AuthGuardEnum::CUSTOMER->value)->user()->id;

        $this->customerService->updateSiteAlign($data);

        success_message(localize("Customer Site Align Change Successfully"));

        return redirect()->back();
    }

}
