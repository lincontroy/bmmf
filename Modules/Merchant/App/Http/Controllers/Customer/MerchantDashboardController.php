<?php

namespace Modules\Merchant\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Modules\Merchant\App\Services\MerchantDashboardService;

class MerchantDashboardController extends Controller
{
    /**
     * MerchantDashboardController of construct
     *
     * @param MerchantDashboardService $merchantDashboardService
     */
    public function __construct(
        protected MerchantDashboardService $merchantDashboardService,
    ) {

    }

    /**
     * Display a listing of the resource.
     * @return mix
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Merchant Dashboard'),
            'description' => localize('Merchant Dashboard'),
        ]);

        $data = $this->merchantDashboardService->dashboardData();

        return view('merchant::customer.dashboard.index', $data);

    }
}
