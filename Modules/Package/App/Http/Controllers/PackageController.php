<?php

namespace Modules\Package\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Package\App\DataTables\PackagesDataTable;
use Modules\Package\App\Http\Requests\PackageRequest;
use Modules\Package\App\Repositories\Interfaces\PlanTimeRepositoryInterface;
use Modules\Package\App\Services\PackageService;

class PackageController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Summary of __construct
     * @param PackageService $packageService
     * @param PlanTimeRepositoryInterface $planTimeRepository
     */
    public function __construct(
        protected PackageService $packageService,
        protected PlanTimeRepositoryInterface $planTimeRepository,
    ) {
        $this->mapActionPermission = [
            'index'           => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::READ->value,
            'create'          => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::CREATE->value,
            'store'           => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::CREATE->value,
            'show'            => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::READ->value,
            'edit'            => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::UPDATE->value,
            'update'          => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::UPDATE->value,
            'destroy'         => PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PackagesDataTable $packagesDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Packages'),
            'description' => localize('Packages'),
        ]);

        $planTimes = $this->planTimeRepository->all();
        $formData  = $this->packageService->formData();

        return $packagesDataTable->render('package::index', compact('planTimes', 'formData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('package::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param PackageRequest $request
     */
    public function store(PackageRequest $request): JsonResponse
    {
        $data    = $request->validated();
        $package = $this->packageService->create($data);
        return response()->json([
            'success' => true,
            'message' => localize("Package create successfully"),
            'title'   => localize("Package"),
            'data'    => $package,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('package::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
