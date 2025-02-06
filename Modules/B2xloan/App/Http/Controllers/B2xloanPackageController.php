<?php

namespace Modules\B2xloan\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\B2xloan\App\DataTables\PackagesDataTable;
use Modules\B2xloan\App\Http\Requests\PackageRequest;
use Modules\B2xloan\App\Services\PackageService;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class B2xloanPackageController extends Controller
{
    use ResponseTrait;
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * WebsiteController constructor
     *
     */
    public function __construct(
        private PackageService $packageService,
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value  . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value  . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value  . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value  . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value  . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PackagesDataTable $packagesDataTable)
    {
        cs_set('theme', [
            'title'       => localize('B2X Available Packages'),
            'description' => localize('B2X Available Packages'),
        ]);

        return $packagesDataTable->render('b2xloan::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageRequest $request): JsonResponse
    {
        $data = $request->validated();

        $package = $this->packageService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Package create successfully"),
            'title'   => localize("Package"),
            'data'    => $package,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('b2xloan::create');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('b2xloan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        $data['package'] = $this->packageService->findById($id);

        return view('b2xloan::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $request, $id): JsonResponse
    {
        $data               = $request->validated();
        $data['package_id'] = $id;

        $package = $this->packageService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Package update successfully"),
            'title'   => localize("Package"),
            'data'    => $package,
        ]);
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
