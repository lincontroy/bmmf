<?php

namespace Modules\Package\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\InvestmentDetailsRepository;
use App\Services\CustomerService;
use App\Services\InvestmentService;
use App\Services\SettingService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Package\App\DataTables\MyPackagesDataTable;
use Modules\Package\App\Http\Requests\PackageBuyRequest;
use Modules\Package\App\Http\Requests\PackageRequest;
use Modules\Package\App\Repositories\Interfaces\PlanTimeRepositoryInterface;
use Modules\Package\App\Services\PackageService;

class PackageController extends Controller
{
    /**
     * Summary of __construct
     *
     * @param PackageService $packageService
     * @param PlanTimeRepositoryInterface $planTimeRepository
     */
    public function __construct(
        protected PackageService $packageService,
        protected PlanTimeRepositoryInterface $planTimeRepository,
        protected SettingService $settingService,
        protected CustomerService $customerService,
        protected InvestmentService $investmentService,
        private InvestmentDetailsRepository $investmentDetailsRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Packages'),
            'description' => localize('Packages'),
        ]);

        $packages = $this->packageService->packagesPaginate();

        return view('package::customer.index', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     * @param PackageBuyRequest $request
     */
    public function store(PackageBuyRequest $request)
    {
        $data = $request->validated();

        $packageId = $request['package_id'];

        $package = $this->packageService->buyPackage($data);

        if ($package->status === false) {
            return redirect()->route('customer.packages.show', [$packageId]
            )->with(['exception' => $package->message]);
        }

        return redirect()->route('customer.packages_purchased', ['id' => $package->id]
        )->with(['success' => localize('Your package buy successfully done')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('package::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(int $id)
    {
        cs_set('theme', [
            'title'       => localize('Packages'),
            'description' => localize('Packages'),
        ]);

        $package        = $this->packageService->findPackageById($id);
        $setting        = $this->settingService->findById();
        $customerInfo   = $this->customerService->findOrFail(Auth::id());
        $lastInvestment = $this->investmentService->getLastInvestment();

        return view('package::customer.show', compact('package', 'customerInfo', 'setting', 'lastInvestment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit(int $id): JsonResponse
    {
        $package = $this->packageService->findById($id);

        return response()->json([
            'success' => true,
            'message' => localize("Package Data"),
            'title'   => localize("Package"),
            'data'    => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $request, $id): JsonResponse
    {
        $data               = $request->validated();
        $data['package_id'] = $id;
        $user               = $this->packageService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Package update successfully"),
            'title'   => localize("Package"),
            'data'    => $user,
        ]);
    }

    public function confirmPackage(int $id)
    {
        cs_set('theme', [
            'title'       => localize('Packages'),
            'description' => localize('Packages'),
        ]);

        $investment     = $this->investmentService->findById($id);
        $setting        = $this->settingService->findById();
        $customerInfo   = $this->customerService->findOrFail(Auth::id());
        $lastInvestment = $this->investmentService->getLastInvestment();

        return view('package::customer.details', compact('investment', 'customerInfo', 'setting', 'lastInvestment'));
    }

    public function myPackages(MyPackagesDataTable $myPackagesDataTable)
    {
        cs_set('theme', [
            'title'       => localize('My Packages'),
            'description' => localize('My Packages'),
        ]);

        return $myPackagesDataTable->render('package::customer.my_packages');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @var int $id
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->packageService->destroy(['package_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Package delete successfully"),
            'title'   => localize("Package"),
        ]);
    }

}
